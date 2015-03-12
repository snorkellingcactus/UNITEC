<?php
if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}

if(isset($_SESSION['adminID'])&&isset($_POST['dom']))
{
	include("./conexion.php");
	include("./Res_XML.php");

	$consulta=$con->query('select * from Opciones where Dominio like "'.$_POST['dom'].'%"');

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