<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepGalBase.php';

	class PasoA_SQLEvts_New extends SrvStepGalBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$session=new FormSession();

			//$afectados=[];

			$i=0;

			while( $session->setIDSuffix( $i ) !== false )
			{
				$session->autoloadLabels();
				$session->loadLabel( 'FileUrl' );

				if
				(
					$session->emptyTrimLabel( 'Titulo' ) ||
					$this->isImgUploadEmpty( $session , 0 )
				)
				{
					++$i;

					continue;
				}
/*
				$con->query
				(
					'	INSERT INTO PrioridadesGrp()
						VALUES()
					'
				);w
*/
				$img=new Img();

				if ( !$session->emptyTrimLabel( 'FileUrl' ) )
				{
					$img->Url=$session->getLabel( 'FileUrl' );
				}

				$img->PrioridadesGrpID=nPriorityGrp();

				$img->Visible=intVal
				(
					filter_var
					(
						$session->getLabel('Visible'),
						FILTER_VALIDATE_BOOLEAN
					)
				);

				$img->Fecha=date("Y-m-d H:i:s");

				$img->insForanea
				(
					nTraduccion
					(
						$session->getLabel( 'Titulo' ) ,
						$_SESSION['lang']
					),
					'TituloID',
					'ContenidoID'
				);

				$img->insForanea
				(
					nTraduccion
					(
						$session->getLabel( 'Alt' ) ,
						$_SESSION['lang']
					),
					'AltID',
					'ContenidoID'
				);
			
				//La inserto en la bd.
				$img->insSQL();

				if ( $session->hasLabel( 'Prioridad' ) )
				{
					$prioridad=$session->getLabel( 'Prioridad' );
				}
				else
				{
					$prioridad=0;
				}

				if ( $session->hasLabel( 'Tags' ) )
				{
					$img->updTagsTargets
					(
						$session->getLabel( 'Tags' )
					);

					updTagsPriority
					(
						$session->getLabel( 'Tags' ),
						$prioridad,
						$img
					);
				}

				$this->mkUpload ( $i , $img->ID , $session );

				++$i;
			}

			$router->gotoOrigin();
		}
		//$this->router->gotoOrigin();

		//$afectados[$i]=$evento->DescripcionID;
		//return $afectados;
	}
?>