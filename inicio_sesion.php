<!DOCTYPE html >
<?php
	//Si todavía no se inicio sesion, se inicia.
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';
	start_session_if_not();
	
	setLangFromID($_SESSION['lang']);
	
	//Si se quiere cerrar sesión redirijo.
	if(isset($_GET['cSesion']))
	{
		$_SESSION['adminID']=NULL;	//Modo admin off.
		
		//Redirección.
		header('Location: inicio_sesion.php');
		die();					//Por un motivo desconocido recomiendan el uso de die()

		//NOTA IMPORTANTE: Location en el futuro debe contener una URL
		//absoluta, o en algunos casos no va a ser efectivo además de
		//no cumplir con el procedimiento estándar.
		//http://stackoverflow.com/questions/768431/how-to-make-a-redirect-in-php
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
		<link rel="stylesheet" type="text/css" href="./forms/forms.css" />
		<link rel="stylesheet" type="text/css" href="./seccs/inicio_sesion.css" />
		<link rel="stylesheet" type="text/css" href="./bootstrap.min.css" />
		<title>Unitec - <?php echo gettext('Inicio Sesión')?></title>
	</head>
	<body>
		<div class="container-fluid" style="padding: 0">
			
			<div class="header">
				<a href='./index.php'><?php echo gettext('Ir al inicio')?></a>
			</div>
		</div>
		<main class="col-xs-10 col-sm-10 col-lg-10">
			<?php
				$msg='';		//Mensaje opcional en el cuadro login.

				//Si se rellenó el formulario login lo valido.
				if(isset($_POST['contrasena'])&&isset($_POST['Nombre']))
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
					//Trato de obtener el usuario.
					$usuario=$con->query('select * from Usuarios where NombreUsuario="'.$_POST['Nombre'].'" and Contrasena="'.sha1($_POST['contrasena']).'"');
				
					//Operaciones a realizar si se obtuvo.
					if($con->affected_rows>0)
					{
						$usuario=fetch_all($usuario , MYSQLI_ASSOC)[0];
						
						//Variable que define el modo administrador.
						$_SESSION['adminID']=$usuario['ID'];
					}
					else
					{
						$msg=gettext('El usuario no existe').'<br/>';
					}
				}

				if(isset($_SESSION['adminID']))
				{
					include $_SERVER['DOCUMENT_ROOT'] . '/seccs/panel_admin.php';	//Incluyo el panel.
				}
				else
				{
					echo '<h2>'.$msg.'</h2>';		//Despliego mensaje opcional.
					include $_SERVER['DOCUMENT_ROOT'] . '/seccs/login.php';		//Formulario login.
				}
			?>
		</main>
</html>