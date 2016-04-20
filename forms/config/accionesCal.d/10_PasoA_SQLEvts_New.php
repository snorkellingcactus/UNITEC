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
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

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

			$contentID=FormActions::getContentID()[0];

			$session=new FormSession();
			$session->autoloadLabels();

			//$afectados=[];

			$i=0;
			while( $session->setIDSuffix( $i ) !==false )
			{
				//$grupo=$con->query('select ifnull(max(Grupo),0) as Grupo from Contenido');
				
				//$grupo=fetch_all($grupo , MYSQLI_ASSOC)[0]['Grupo']+1;

				$fecha=date
				(
					'Y-m-d H:i:s',
					mktime
					(
						$session->getLabel('Horas'),
						$session->getLabel('Minutos'),
						0,
						$session->getLabel('Mes'),
						$session->getLabel('Dia'),
						$session->getLabel('Ano')
					)
				);

				$evento=new Evento
				(
					[
						'Tiempo'=>$fecha,
						'Prioridad'=>$session->getLabel('Prioridad'),
						'Visible'=>intVal
						(
							filter_var
							(
								$session->getLabel('Prioridad'),
								FILTER_VALIDATE_BOOLEAN
							)
						)
					]
				);
				$evento->insForanea
				(

					nTraduccion
					(
						$session->getLabel('Descripcion'),
						$_SESSION['lang']
					),
					'DescripcionID',
					'ContenidoID'
				);
				$evento->insForanea
				(

					nTraduccion
					(
						$session->getLabel('Titulo') ,
						$_SESSION['lang']
					),
					'NombreID',
					'ContenidoID'
				);

				$evento->insSQL();

				if($session->hasLabel('Tags'))
				{
					$evento->updTagsTargets
					(
						$session->getLabel('Tags')
					);
				}

				++$i;
			}	

		}
		//$this->router->gotoOrigin();

		//$afectados[$i]=$evento->DescripcionID;
		//return $afectados;
	}
?>