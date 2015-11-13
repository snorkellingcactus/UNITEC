<!DOCTYPE HTML >
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php');
	detectLang();

	if(!isset($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	}
	include $_SERVER['DOCUMENT_ROOT'] . '/php/FormSrvBuilder.php';

	$formHandler=new FormSrvBuilder();

	$lang=substr(getenv('LANG'), 0 , 2);
	?>
		<html lang="<?php echo $lang?>">
			<head>
				<meta charset="utf-8" />

				<link rel="icon" type="image/png" href="/img/unitec-favicon.png"  />
				<link rel="shortcut icon" type="image/ico" href="/img/unitec-favicon.ico"  />
				<!--::::::Includes comunes a todos los formularios::::::-->
				<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
				<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
				<link rel="stylesheet" type="text/css" href="../forms/forms.css" />
				<script type="text/javascript" src="/js/head.js"></script>
				<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
				<script type="text/javascript" src="/js/loadEditor.js"></script>

				<!--::::::Includes variables pasados por parametro::::::-->
				<?php
					$formHandler->getReqs();
				?>

			</head>
			<body>

					<?php
/*
						echo '<pre>SESSION:';
						print_r($_SESSION);
						echo '</pre>';
*/
						echo $formHandler->buildAll()->form->getHTML();
					?>
				<div class="clearfix"></div>
			</body>
		</html>
	<?php

?>