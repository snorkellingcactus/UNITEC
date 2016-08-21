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
				$nSec->ModuloID=intVal( $session->getLabel('Modulo') );

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';

				$opcGrp=getOpcGrpModulo($contentID);

				if(isset($opcGrp[0][0]))
				{
					$opciones=getAllOpcGrp( $opcGrp[0][0] );

					$i=0;
					while(isset($opciones[$i]))
					{
						$opcion=$opciones[$i];

						//Revisar. Si no existe $opcGrp[0][1], crearlo.

						if( !$session->emptyTrimLabel( $opcion['NombreID'] ) && isset($opcGrp[0][1]) )
						{
							updVal
							(
								$opcion['ID'] ,
								$opcGrp[0][1] ,
								$session->getLabel( $opcion['NombreID'] )
							);
						}

						++$i;
					}
				}
			}

			if( $session->hasLabel('Contenido') )
			{
				include_once	$_SERVER['DOCUMENT_ROOT'] . '/php/splitInlineCssToFile.php';

				if( $action & FormActions::FORM_ACTIONS_EDIT )
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
				}
				else
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

					$descripcion=nTraduccion
					(
						'' ,
						$_SESSION['lang']
					);

					$descripcion->insSQL();

					$nSec->ContenidoID=$descripcion->ContenidoID;
				}

				include_once	$_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

				updTraduccion
				(
					splitInlineCssToFile
					(
						$session->getLabel( 'Contenido' ) ,
						$nSec->ContenidoID
					),
					$nSec->ContenidoID ,
					$_SESSION['lang']
				);
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

			$atajo=false;
			if( !$session->emptyTrimLabel( 'Atajo' ) )
			{
				$atajo=strtoupper
				(
					trim
					(
						$session->getLabel( 'Atajo' )
					)
				);
			}

			$titulo=false;
			if( $session->hasLabel( 'Titulo' ) )
			{
				$titulo=$session->getLabel( 'Titulo' );
			}

			if( $action & FormActions::FORM_ACTIONS_EDIT )
			{
				$nSec->ID=$contentID;
				
				$nSec->updSQL( false , [ 'ID' ] );
			}
			else
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

				if( $atajo !== false )
				{
					$nSec->insForanea
					(
						nTraduccion
						(
							$atajo,
							$_SESSION['lang']
						),
						'AtajoID',
						'ContenidoID'
					);
				}
				if( $titulo!==false )
				{
					$nSec->insForanea
					(
						nTraduccion
						(
							$titulo,
							$_SESSION['lang']	
						),
						'TituloID',
						'ContenidoID'
					);
				}

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

			if( $action & FormActions::FORM_ACTIONS_EDIT )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

				if( $titulo !== false )
				{
					updTraduccion( $titulo, $nSec->TituloID , $_SESSION['lang'] );
				}

				if( $atajo !== false )
				{
					updTraduccion( $atajo , $nSec->AtajoID , $_SESSION['lang'] );
				}
			}
			
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

			$enMenu=$session->hasLabel('AgregarAlMenu') && filter_var
			(
				$session->getLabel('AgregarAlMenu') ,
				FILTER_VALIDATE_BOOLEAN
			);
			$menuID=fetch_all
			(
				$con->query
				(
					'	SELECT Menu.ID
						FROM Menu
						WHERE Menu.SeccionID = '.$nSec->ID
				),
				MYSQLI_NUM
			);

			if( isset( $menuID[0][0] ) != $enMenu )
			{
				$_SESSION['form']='accionesMenu';

				$menuSession=new FormSession();

				if( $enMenu )
				{
					$menuSession->setLabel
					(
						'Url' ,
						'#'.rawurlencode( $titulo )
					)->setLabel
					(
						'Visible' ,
						$nSec->Visible
					)->setLabel
					(
						'SeccionID' ,
						$nSec->ID
					)->setLabel
					(
						'Titulo' ,
						$titulo
					);

					if($session->hasLabel('Tags'))
					{
						$menuSession->setLabel( 'Tags' , $session->getLabel('Tags') );
					}

					FormActions::replaceSessionAction( $action , FormActions::FORM_ACTIONS_NEW );
				}
				else
				{
					$_SESSION['conID']=$menuID[0][0];
					FormActions::replaceSessionAction( $action , FormActions::FORM_ACTIONS_DELETE );
				}

				$menuSession->save();

				$router->setFormDir('accionesMenu');

				//Nombre del fichero en accionesMenu.d
				$router->redirectToStepName( '00_PasoA.class.php' );
			}
			$router->gotoOrigin();
		}
	}
	//$formLab=new FormCliRecv('Sec');
	//$formLab->SQL_Evts=new SQL_Evts_Secciones();
	//$formLab->checks();

	//$this->redirect($this->getOriginUrl());
?>