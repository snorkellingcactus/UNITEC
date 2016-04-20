<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_Edit extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			echo '<pre>$_SESSION:';
			print_r($_SESSION);
			echo '</pre>';
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$contentID=FormActions::getContentID()[0];

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;


			$session=new FormSession();
			$session->autoloadLabels();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Evento.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Traduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

			$evento=new Evento();

			$iMax=$_SESSION['cantidad'];
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				$evento->getSQL(['DescripcionID'=>$_SESSION['conID'][$i]]);
				$evento->getAsoc
				(
					[
						'Tiempo'=>$_POST['Ano'][$i].'-'.$_POST['Mes'][$i].'-'.$_POST['Dia'][$i].' '.$_POST['Horas'][$i].':'.$_POST['Minutos'][$i],
						'Visible'=>$_POST['Visible'][$i],
						'Prioridad'=>$_POST['Prioridad'][$i]
					]
				);

				updTraduccion($_POST['Descripcion'][$i] , $_SESSION['conID'][$i] , $_SESSION['lang']);
				updTraduccion($_POST['Titulo'][$i] , $evento->NombreID , $_SESSION['lang']);

				//echo '<pre>A insertar: ';print_r($evento);echo '</pre>';

				$evento->updSQL
				(
					false,
					[
						'DescripcionID'=>$_SESSION['conID'][$i]
					]
				);

				if(!empty($_POST['Tags'][$i]))
				{
					$evento->updTagsTargets($_POST['Tags'][$i]);
				}

				$afectados[$i]=$_SESSION['conID'][$i];
			}
			return $afectados;

			//$afectados[$i]=$conIdAct;
			
			//return $afectados;

			//$this->router->gotoOrigin();
		}
	}
?>