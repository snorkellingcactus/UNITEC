<!DOCTYPE HTML >
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
if(isset($_SESSION['adminID']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/php/FormSrvBuilder.php';

	$formHandler=new FormSrvBuilder();
	
	$formHandler->getConfig();
	?>
		<html lang="es">
			<head>
				<meta charset="utf-8" />

				<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
				<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
				<!--::::::Includes comunes a todos los formularios::::::-->
				<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
				<link rel="stylesheet" type="text/css" href="../forms/forms.css" />

				<!--::::::Includes variables pasados por parametro::::::-->
				<?php
					$formHandler->buildIncludes();
				?>

			</head>
			<body>
					<?php
						$formHandler->buildForms();
					?>
				<div class="clearfix"></div>
			</body>
		</html>
	<?php
}
?>