<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Comentarios_Normal.php';

	class SQL_Evts_Comentarios_Admin extends SQL_Evts_Comentarios_Normal implements SQL_Evts_List
	{
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
			global $con;

			$conID=$_SESSION['conID'];

			$iMax=count($conID);
			for($i=0;$i<$iMax;$i++)
			{
				$con->query('DELETE FROM Contenidos WHERE ID='.$conID[$i]);

				//echo '<pre>'.'DELETE FROM Contenidos WHERE ID='.$conID[$i].'</pre>';
			}

			$res=$_SESSION['conID'];

			unset($_SESSION['conID'] , $_SESSION['form']);

			return $res;
		}
	}

?>