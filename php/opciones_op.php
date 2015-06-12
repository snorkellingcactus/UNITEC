<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(!empty($_SESSION['adminID']) && isset($_POST['accion']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';

	$consulta=false;

	if(isset($_POST['datos']))
	{
		$datos=$_POST['datos'];
	
		switch($_POST['accion'])
		{
			//Nueva.
			case 0:
				$consulta='insert into `Opciones` (Dominio , Tipo , Valor) values ("'.$datos[0].'" , '.$datos[1].' , "'.$datos[2].'")';
			break;
			//Actualiza.
			case 1:
				$id=$_POST['id'];
				$claves=['Dominio','Tipo','Valor'];
				$iMax=count($datos);

				$iAct=0;

				while($datos[$iAct]==='undefined' && $iAct<$iMax)
				{
					$iAct++;
				}

				$consulta='update Opciones set '.$claves[$iAct].' = "'.$datos[$iAct].'" where ID='.$id;
			break;
		}
	}
	else
	{
		if(isset($_POST['id']))
		{
			$consulta='delete from Opciones where ID='.$_POST['id'];
		}
	}

	

	if($consulta)
	{
		$consulta=$con->query($consulta);

		if($_POST['accion']==0)
		{
			$_POST['id']=$con->insert_id;
		}

		include $_SERVER['DOCUMENT_ROOT'] . '//php/getConfig.php';
	}
}

?>