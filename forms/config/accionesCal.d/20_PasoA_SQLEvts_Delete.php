<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_Delete extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			echo '<pre>';
			print_r('existo');
			echo '</pre>';

			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$contentID=FormActions::getContentID();

			echo '<pre>contentID : ';
			print_r($contentID);
			echo '</pre>';

			$i=0;
			while( isset($contentID[$i]) )
			{
				$nombreID=fetch_all
				(
					$con->query
					(
						'	SELECT NombreID
							FROM Eventos
							WHERE DescripcionID = '.FormActions::getContentID()[$i]
					),
					MYSQLI_NUM
				)[0][0];

				//echo '<pre>Elimina Evento: '.'delete from Contenidos where ID='.FormActions::getContentID()[$i].'</pre>';

				$con->query('delete from Contenidos where ID='.$nombreID);
				$con->query('delete from Contenidos where ID='.FormActions::getContentID()[$i]);

				++$i;
			}
			

			//$this->router->gotoOrigin();

			//$afectados[$i]=$nMenu->ContenidoID;
			//return $afectados;

		}
	}
?>