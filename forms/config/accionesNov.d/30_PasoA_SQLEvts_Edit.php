<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_Edit extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$contentID=FormActions::getContentID();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;


			$session=new FormSession();
			$session->autoloadLabels();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Traduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

			$nNov=new Novedad();

			$i=0;
			while( $session->setIDSuffix( $i ) )
			{
				$session->autoloadLabels();
				$session->loadLabels( 'Imagen' );

				if
				(
					$session->emptyTrimLabel( 'Contenido' ) ||
					$session->emptyTrimLabel( 'Titulo' ) ||
					$session->emptyTrimLabel( 'Tags' )
				)
				{
					++$i;

					continue;
				}

				//$session->loadLabels( 'Ano' , 'Mes' , 'Dia' , 'Horas' , 'Minutos' );

				$nNov->getSQL
				(
					[
						'ID'=>each($contentID)['value']
					]
				);

				$nNov->ImagenID=$session->getLabel( 'Imagen' );

				$nNov->Visible=intVal
				(
					filter_var
					(
						$session->getLabel('Visible') ,
						FILTER_VALIDATE_BOOLEAN
					)
				);
				$nNov->updSQL
				(
					false ,
					['ID']
				);

				updTraduccion
				(
					$session->getLabel( 'Contenido' ),
					$nNov->DescripcionID,
					$_SESSION['lang']
				);
				updTraduccion
				(
					$session->getLabel( 'Titulo' ) ,
					$nNov->TituloID ,
					$_SESSION['lang']
				);

				//$afectados[$i]=$nNov->TituloID;

				if(!$session->emptyTrimLabel('Tags'))
				{
					$nNov->updTagsTargets
					(
						$session->getLabel( 'Tags' )
					);

					updTagsPriority
					(
						$session->getLabel( 'Tags' ),
						$session->getLabel( 'Prioridad' ),
						$nNov
					);
				}

				++$i;
			}
			//return $afectados;

			//$afectados[$i]=$conIdAct;
			
			//return $afectados;

			$router->gotoOrigin();
		}
	}
?>