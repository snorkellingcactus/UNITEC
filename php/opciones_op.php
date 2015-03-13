<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(!empty($_SESSION['adminID']) && isset($_POST['accion']))
{
	include("./conexion.php");

	$consulta=false;

	switch($_POST['accion'])
	{
		//Nueva.
		case 0:
			$datos=$_POST['datos'];

			$consulta=$con->query('insert into `Opciones` (Dominio , Tipo , Valor) values ("'.$datos[0].'" , '.$datos[1].' , "'.$datos[2].'")');
		break;
	}

	if($_POST['accion']==0&&$consulta)
	{
		$_POST['id']=$con->insert_id;
		include("./getConfig.php");
	}

}

?>