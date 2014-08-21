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
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
				
				<link rel="icon" type="image/png" href="./img/unitec-favicon.png"  />
				<link rel="shortcut icon" type="image/ico" href="./img/unitec-favicon.ico"  />
				<link rel="stylesheet" type="text/css" href="./index.css" />
				<link rel="stylesheet" type="text/css" href="./header.css" />
				<link rel="stylesheet" type="text/css" href="./seccs/menu.css" />
				<link rel="stylesheet" type="text/css" href="./seccs/inicio_sesion.css" />
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
				<!-- usad para utlizar las propiedades responsive de bootstrap -->
				<div class="container-fluid" style="padding: 0">
					
					<div class="header">
						<a href='./index.php'>Ir Atrás</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-lg-2">
					<?php
					     include_once("./seccs/menu.php");
					     ?>
				</div>
				<main class="col-xs-10 col-sm-10 col-lg-10">
					<?php
						include './seccs/inicio_sesion.php';
					?>
				</main>
			</html>