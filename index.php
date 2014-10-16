<!DOCTYPE html >
<?php
include_once 'php/SQLObj.php';
include_once 'php/Img.php';

//Si todavía no se inicio sesion, se inicia.
if(session_status()==PHP_SESSION_NONE)
{
	session_start();		
}
//Si no se indicó resaltar ninguna opcion, se resalta el inicio (opcion 0).
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

		<!--:::::::::::::::Atajos de teclado:::::::::::::::-->
		<a href="./index.php?OpcSel=0#sobre" accesskey="i"></a>
		<a href="./index.php?OpcSel=1#nov" accesskey="n"></a>
		<a href="./index.php?OpcSel=2#labs" accesskey="l"></a>
		<a href="./index.php?OpcSel=3#cal" accesskey="c"></a>
		<a href="./index.php?OpcSel=4#gal" accesskey="g"></a>
		<title>Unitec</title>
	</head>
<body>
	<div class="header hidden-xs">
		<a href="./inicio_sesion.php">Iniciar Sesión</a>
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
</body>
</html>

