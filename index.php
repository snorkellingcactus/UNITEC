<!DOCTYPE html >
<?php
include './php/Conexion.php';
include './php/Img.php';

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
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    
		<link rel="icon" type="image/png" href="./img/unitec-favicon.png"  />
		<link rel="shortcut icon" type="image/ico" href="./img/unitec-favicon.ico"  />
		<link rel="stylesheet" type="text/css" href="./index.css" />
		<link rel="stylesheet" type="text/css" href="./header.css" />
		<link rel="stylesheet" type="text/css" href="./footer.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/menu.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/organigrama.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/calendario.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/sobre_unitec.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/galeria.css" />
		<link rel="stylesheet" type="text/css" href="./bootstrap.min.css" />
		<title>Unitec</title>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    		<!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    		<![endif]-->
	</head>
<body>
	<!-- esta para utlizar las propiedades responsive de bootstrap -->
	<div class="container-fluid" style="padding: 0">

		
		<div class="header hidden-xs">
			<a href="./inicio_sesion.php">Iniciar Sesión</a>
		</div>
	</div>
<?php
	include_once("./seccs/menu.php");
?>
	<main class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
	<?php
		$_GET['mes']=getdate()['mon'];	//Acá indicar mes que se muestra por defecto. Va a mostrarse el mes indicado -1.
		include_once('./seccs/sobre_unitec.php');
		include_once('./seccs/novedades.php');
		include_once('./seccs/organigrama.php');
		include_once('./seccs/calendario.php');
		include_once('./seccs/galeria.php');
	?>
	</main>
		<div class="footer"> <c> powered by bootstrap </c></div>
</html>

