<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$action=FormActions::checkActionIn($_POST);

			if($action===false)
			{
				$action=FormActions::checkActionIn($_SESSION);
			}

			$contentID=FormActions::getContentID()[0];


			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Seccion.php';

			global $con;

			$session=new FormSession();
			$session->autoloadLabels();
/*
			if(isset($_SESSION['conID'][0]) && is_array($_SESSION['conID']))
			{
				$_SESSION['conID']=$_SESSION['conID'][0];
			}
*/			
			$nSec=new Seccion();

			//Un módulo.
			if($session->hasLabel('Modulo'))
			{
				$nSec->ModuloID=intVal($session->getLabel('Modulo'));

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';

				$opcGrp=getOpcGrpModulo($contentID);

				if(isset($opcGrp[0][0]))
				{
					$opciones=getAllOpcGrp($opcGrp[0][0]);
					$i=0;
					while(isset($opciones[$i]))
					{
						$opcion=$opciones[$i];

						if(isset($_POST[$opcion['Nombre']]) && isset($opcGrp[0][1]))
						{
							updVal($opcion['ID'] , $opcGrp[0][1] , $_POST[$opcion['Nombre']][0]);
						}

						++$i;
					}
				}
			}
			if($session->hasLabel('Titulo'))
			{
				$nSec->HTMLID=htmlentities
				(
					$session->getLabel('Titulo')
				);
			}

			if($session->hasLabel('Contenido'))
			{
				if($action & FormActions::FORM_ACTIONS_EDIT)
				{
					$nSec->ContenidoID=fetch_all
					(
						$con->query
						(
							'	SELECT ContenidoID
								FROM Secciones
								WHERE ID='.$contentID
						),
						MYSQLI_NUM
					)[0][0];

					include_once	$_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

					updTraduccion
					(
						$session->getLabel( 'Contenido' ) ,
						$nSec->ContenidoID ,
						$_SESSION['lang']
					);
				}
				else
				{
					include_once	$_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

					$descripcion=nTraduccion
					(
						$session->getLabel('Contenido') ,
						$_SESSION['lang']
					);

					$descripcion->insSQL();

					$nSec->ContenidoID=$descripcion->ContenidoID;
				}
			}

			if($session->hasLabel('Modulo') || $session->hasLabel('Contenido'))
			{
				if($action & FormActions::FORM_ACTIONS_EDIT)
				{
					$nSec->PadreID=fetch_all
					(
						$con->query
						(
							'	SELECT PadreID
								FROM Secciones
								WHERE ID='.$contentID
						),
						MYSQLI_NUM
					)[0][0];	
				}
				else
				{
					$nSec->PadreID=$contentID;
				}
				
				$condicion=' Secciones.PadreID='.$nSec->PadreID;
			}
			else
			{
				$condicion=' Secciones.ContenidoID IS NULL AND Secciones.ModuloID IS NULL';
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

			$nSec->Visible=intVal
			(
				filter_var
				(
					$session->getLabel('Visible') ,
					FILTER_VALIDATE_BOOLEAN
				)
			);

			if($action & FormActions::FORM_ACTIONS_EDIT)
			{
				$nSec->ID=$contentID;
				
				$nSec->updSQL(false,['ID']);
			}
			else
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

				$nSec->PrioridadesGrpID=nPriorityGrp();

				$nSec->insSQL();
			}
			$nSec->getSQL
			(
				[
					'ID'=>$nSec->ID
				]
			);
			
			//Revisar. Seguridad.

			if($session->hasLabel('Tags'))
			{
				$nSec->updTagsTargets
				(
					$session->getLabel('Tags')
				);

				updLabsTagsPriority
				(
					$session->getLabel('Tags'),
					$nSec,
					$condicion,
					$session->getLabel('Lugar'),
					'ID',
					$action & FormActions::FORM_ACTIONS_EDIT
				);
			}

			if
			(
				$nSec->HTMLID!==NULL &&
				(
					$session->hasLabel('Atajo') ||
					(
						$session->hasLabel('AgregarAlMenu') &&
						$session->getLabel('AgregarAlMenu')==='true'
					)
				)
			)
			{
				$_SESSION['form']='accionesMenu';

				$menuSession=new FormSession();

				$menuSession->setLabel
				(
					'Url' ,
					'#'.rawurlencode( $nSec->HTMLID )
				)->setLabel
				(
					'Visible' ,
					$nSec->Visible
				)->setLabel
				(
					'SeccionID' ,
					$nSec->HTMLID
				);



				$mContentID=fetch_all
				(
					$con->query
					(
						'	SELECT ContenidoID
							FROM Menu
							WHERE SeccionID="'.$nSec->HTMLID.'"'
					),
					MYSQLI_NUM
				);

				if($session->hasLabel('Atajo'))
				{
					$menuSession->setLabel
					(
						'Atajo' ,
						strtoupper
						(
							$session->getLabel('Atajo')
						)
					);
				}

				if(empty($mContentID[0][0]))
				{
					$menuSession
					->setLabel( 'Titulo' , $nSec->HTMLID )
					->setLabel( 'Lugar' , 'b' );

					if($session->hasLabel('Tags'))
					{
						$menuSession->setLabel( 'Tags' , $session->getLabel('Tags') );
					}

					FormActions::replaceSessionAction( $action , FormActions::FORM_ACTIONS_NEW );
				}
				else
				{
					//Revisar . Realizar mediante FormActions.
					$_SESSION['conID']=[$mContentID[0][0]];

					FormActions::replaceSessionAction( $action , FormActions::FORM_ACTIONS_EDIT );
				}

				$menuSession->save();
				$router->setFormDir('accionesMenu');

				$router->redirectToStepName('00_PasoA.class.php');
			}

			//$router->gotoOrigin();
		}
	}
	//$formLab=new FormCliRecv('Sec');
	//$formLab->SQL_Evts=new SQL_Evts_Secciones();
	//$formLab->checks();

	//$this->redirect($this->getOriginUrl());
?>