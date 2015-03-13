<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(!empty($_SESSION['adminID']) && isset($_POST['accion']))
{
	echo 'Hola';
	include("./conexion.php");

	switch($_POST['accion'])
	{
		//Nueva.
		case 0:
			$datos=$_POST['datos'];

			$consulta=$con->query('insert into `Opciones` (Dominio , Tipo , Valor) values ("'.$datos[0].'" , '.$datos[1].' , "'.$datos[2].'")');
		break;
	}
}

?>