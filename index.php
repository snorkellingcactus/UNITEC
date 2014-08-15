<!DOCTYPE html >
<?php
//Precondiciones necesarias.
if(!isset($num))
{
	$num=0;
};
if(!isset($_GET["OpcSel"]))
{
	$_GET["OpcSel"]=0;
}


//Resalta la función del menú correspondiente.
function resaltaOpcN($num)
{
	if($_GET["OpcSel"]==$num)
	{
		echo 'class="resaltaOpc"';
	}
}
?>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="Página principal Unitec." />
		
		<link rel="icon" type="image/png" href="./img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="./img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="./index.css" />
		<link rel="stylesheet" type="text/css" href="./header.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/menu.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/organigrama.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/calendario.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/sobre_unitec.css" />
		<title>Unitec</title>
	</head>
<body>
<div class="header">
		<a href="#login">Iniciar Sesión</a>
</div>
<?php
	include_once("./seccs/menu.php");
?>

<main>
	<?php
		include_once("./seccs/sobre_unitec.php");
		include_once("./seccs/organigrama.php");
		include_once("./seccs/calendario.php");
	?>
</main>
</html>

