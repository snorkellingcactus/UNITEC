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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Traduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

			$evento=new Evento();

			$i=0;
			while( $session->setIDSuffix( $i ) )
			{
				$contentIDAct=each($contentID)['value'];
				$session->autoloadLabels();
				$session->loadLabels( 'Ano' , 'Mes' , 'Dia' , 'Horas' , 'Minutos' );

				$evento->getSQL
				(
					[
						'DescripcionID'=>$contentIDAct
					]
				);
				$evento->getAsoc
				(
					[
						'Tiempo'	=>	$session->getLabel('Ano').'-'.
										$session->getLabel('Mes').'-'.
										$session->getLabel('Dia').' '.
										$session->getLabel('Horas').':'.
										$session->getLabel('Minutos'),
						'Visible'	=>	$session->getLabel('Visible'),
						'Prioridad'	=>	$session->getLabel('Prioridad')
					]
				);

				updTraduccion( $session->getLabel('Descripcion'),	$contentIDAct		, $_SESSION['lang']	);
				updTraduccion( $session->getLabel('Titulo')		,	$evento->NombreID	, $_SESSION['lang']	);

				//echo '<pre>A insertar: ';print_r($evento);echo '</pre>';

				$evento->updSQL
				(
					false,
					[
						'DescripcionID'=>$contentIDAct
					]
				);

				if(!$session->emptyTrimLabel('Tags'))
				{
					$evento->updTagsTargets
					(
						$session->getLabel('Tags')
					);
				}

				++$i;
			}
			//return $afectados;

			//$afectados[$i]=$conIdAct;
			
			$router->gotoOrigin();
		}
	}
?>