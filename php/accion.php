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
				<script type="text/javascript" src="/js/head.js"></script>

				<!--::::::Includes variables pasados por parametro::::::-->
				<?php
					$formHandler->form->getReqs();
				?>

			</head>
			<body>
					<?php
						$iMax=$formBuilder->cantidad;
						for($i=0;$i<$iMax;$i++)
						{
							$formHandler->form->classList->add('tresem')->add('nuevo');
							echo $formHandler->buildNext($i);
						}
					?>
				<div class="clearfix"></div>
			</body>
		</html>
	<?php
}
?>