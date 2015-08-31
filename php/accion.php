<!DOCTYPE HTML >
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();
if(isset($_SESSION['adminID']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/php/FormSrvBuilder.php';

	$formHandler=new FormSrvBuilder();

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
				<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
				<script type="text/javascript" src="/js/loadEditor.js"></script>

				<!--::::::Includes variables pasados por parametro::::::-->
				<?php
					$first='';
					ob_start();
					$formHandler->buildNext();

					$first=ob_get_contents();
					ob_end_clean();

					$formHandler->form->getReqs();
				?>

			</head>
			<body>
					<?php
					echo $first;
					//$formHandler->form->setIDSuffix('jj')->classList->add('tresem')->add('nuevo');
					//echo $formHandler->form->getHTML();
					

					/*
						$iMax=$formHandler->cantidad;
						for($i=0;$i<$iMax;$i++)
						{
							$form=new Form();
							$form->classList->add('tresem')->add('nuevo');

							echo $formHandler->buildNext($form , $i);
						}
					*/
					?>
				<div class="clearfix"></div>
			</body>
		</html>
	<?php
}
?>