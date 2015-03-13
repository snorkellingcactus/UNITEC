<?php
if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}

if(isset($_SESSION['adminID']))
{
	if(!(isset($_POST['dom']) || isset($_POST['id'])))
	{
		return;
	}
	if(isset($_POST['dom']))
	{
		$consulta='select * from Opciones where Dominio like "'.$_POST['dom'].'%"';
	}
	else
	{
		$consulta='select * from Opciones where ID='.$_POST['id'];
	}
	include("./conexion.php");
	include("./Res_XML.php");

	$consulta=$con->query($consulta);

	$consulta=$consulta->fetch_all(MYSQLI_ASSOC);

	$res=new Res_XML();

	$res->ini();

	$iMax=count($consulta);
	for($i=0;$i<$iMax;$i++)
	{
		echo '<Opcion>';

		$consAct=$consulta[$i];
		foreach($consAct as $clave=>$valor)
		{
			if($valor===NULL)
			{
				$valor='null';
			}
			$res->param($clave , $valor);
		}
		echo '</Opcion>';
	}

	$res->fin();
}
?>