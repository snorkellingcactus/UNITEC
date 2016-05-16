<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_New extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$contentID=FormActions::getContentID()[0];

			$session=new FormSession();

			//$afectados=[];

			$i=0;
			while( $session->setIDSuffix( $i ) !==false )
			{
				$session->autoloadLabels();
				$session->loadLabel( 'Imagen' );
				//$session->loadLabels('Horas' , 'Minutos' , 'Mes' , 'Dia' , 'Ano');

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

				$horaLoc=getdate();

				$nov=new Novedad();

				$nov->ImagenID=$session->getLabel( 'Imagen' );
				$nov->Fecha=$horaLoc['year'].'-'.$horaLoc['mon'].'-'.$horaLoc['mday'];
				
				$nov->PrioridadesGrpID=nPriorityGrp();
				$nov->Visible=$session->getLabel( 'Visible' );

				$nov->insForanea
				(
					nTraduccion
					(
						$session->getLabel( 'Contenido' ),
						$_SESSION['lang']
					),
					'DescripcionID',
					'ContenidoID'
				);
				$nov->insForanea
				(
					nTraduccion
					(
						$session->getLabel( 'Titulo' ),
						$_SESSION['lang']
					),
					'TituloID',
					'ContenidoID'
				);

				$nov->insSQL();

				if(!$session->emptyTrimLabel( 'Tags' ))
				{
					$nov->updTagsTargets
					(
						$session->getLabel( 'Tags' )
					);
					updTagsPriority
					(
						$session->getLabel( 'Tags' ),
						$session->getLabel( 'Prioridad' ),
						$nov
					);
				}

				//$afectados[$i]=$nov->TituloID;
				++$i;
			}

			$router->gotoOrigin();
		}
		//$this->router->gotoOrigin();

		//$afectados[$i]=$evento->DescripcionID;
		//return $afectados;
	}
?>