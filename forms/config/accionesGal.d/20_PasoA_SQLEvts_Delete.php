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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$contentID=FormActions::getContentID();

			echo '<pre>contentID : ';
			print_r($contentID);
			echo '</pre>';

			$i=0;
			foreach( $contentID as $name=>$contentIDAct )
			{

				$imgID=fetch_all
				(
					$con->query
					(
						'	SELECT ID
							FROM Imagenes
							WHERE TituloID='.$contentIDAct
					),
					MYSQLI_NUM
				)[0][0];

				elimina ( $_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/'.$imgID.'.png'	, 0775	);
				elimina ( $_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/'	.$imgID.'.png'	, 0775	);

				echo '<pre>';
				print_r
				(
					'	DELETE FROM Contenidos
						WHERE ID='.$contentIDAct
				);
				echo '</pre>';

				$con->query
				(
					'	DELETE FROM Contenidos
						WHERE ID='.$contentIDAct
				);

				++$i;
			}
			

			//$this->router->gotoOrigin();

			//$afectados[$i]=$nMenu->ContenidoID;
			//return $afectados;

		}
	}
?>