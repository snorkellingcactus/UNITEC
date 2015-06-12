<?php
//Inicio Sesión.
if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}

if(isset($_SESSION['adminID']))
{
	//Configura peticion.
	if(!(empty($_POST['dom']) || isset($_POST['id'])))
	{
		$consulta='select * from Opciones2';
	}
	if(isset($_POST['dom']))
	{
		$consulta='select * from Opciones2 where Dominio like "'.$_POST['dom'].'%"';
	}
	else
	{
		$consulta='select * from Opciones2 where ID='.$_POST['id'];
	}

	//Hago la peticion.
	include $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
	include $_SERVER['DOCUMENT_ROOT'] . '//php/Res_XML.php';

	$old=$consulta;

	$consulta=$con->query($consulta);

	$consulta=fetch_all($consulta , MYSQLI_ASSOC);

	if(!count($consulta))
	{
		echo $old;

		return;
	}

	//Escribo la respuesta.

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