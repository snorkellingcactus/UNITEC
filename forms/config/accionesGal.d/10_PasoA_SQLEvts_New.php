<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepImgUploadBase.php';

	class PasoA_SQLEvts_New extends SrvStepImgUploadBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			echo '<pre>$_SESSION:';
			print_r
			(
				$_SESSION
			);
			echo '</pre>';

			echo '<pre>$_POST:';
			print_r
			(
				$_POST
			);
			echo '</pre>';
			echo '<pre>$_FILES:';
			print_r
			(
				$_FILES
			);
			echo '</pre>';

			$contentID=FormActions::getContentID()[0];

			$session=new FormSession();

			//$afectados=[];

			$i=0;
			while( $session->setIDSuffix( $i ) !== false )
			{
				echo '<pre>Processing request '.$i;
				echo '</pre>';
				$session->autoloadLabels();
				$session->loadLabel( 'Url' );

				if
				(
					!$session->hasLabel( 'Titulo' ) ||
					(
						$session->emptyTrimLabel( 'Url' ) &&
						empty($_FILES['Archivo']['name'][$i])
					)
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
				);
*/
				$img=new Img();

				if ( !$session->emptyTrimLabel( 'Url' ) )
				{
					$img->Url=$session->getLabel( 'Url' );
				}

				$img->PrioridadesGrpID=nPriorityGrp();

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
		}
		//$this->router->gotoOrigin();

		//$afectados[$i]=$evento->DescripcionID;
		//return $afectados;
	}
?>