<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_POST['elimina']))
{
	$_SESSION['form']=$_POST['form'];
	$_SESSION['accion']='elimina';

	if(isset($_POST['secID']))
	{
		$_SESSION['secID']=$_POST['secID'];
	}
	else
	{
		$_SESSION['conID']=$_POST['conID'];
	}
	
	header('Location: '.$_SERVER['HTTP_REFERER']);

	die();
}
if(isset($_POST['nMenu']))
{
	$_SESSION['accion']='nMenu';
	$_SESSION['form']=$_POST['form'];

	if(isset($_POST['secID']))
	{
		$_SESSION['secID']=$_POST['secID'];
	}
	else
	{
		$_SESSION['conID']=$_POST['conID'];
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);

	die();
}
if(isset($_POST['edita']))
{
	$_SESSION['form']=$_POST['form'];
	$_SESSION['accion']='edita';
	$_SESSION['conID']=$_POST['conID'];
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/head_include.php';
//Construyo el formulario con la configuración dada y lo devuelvo como string.
function crea_form($labels , $autocomp)
{
	$lMax=count($labels);

	$buff='';
	for($l=0;$l<$lMax;$l++)
	{
		$labelAct=$labels[$l];

		$tipo=$labelAct[0];
		$labelName=$labelAct[1];

		ob_start();
		
		?>
			<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<label for="<?php echo $labelName ?>"><?php echo $labelName ?>:</label>
			</p>

			<?php include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/'.$tipo; ?>

			<div class="clearfix"></div>

		<?php

		$buff=$buff.ob_get_contents();
		ob_end_clean();
	}

	//unset($l , $labelName , $labelAct , $labels);

	return $buff;
}
if(isset($_SESSION['adminID']))
{
	$cantidad=1;

	if(isset($_POST['cantidad']))
	{
		$cantidad=$_POST['cantidad'];
	}
	
	if( isset($_POST['form']) )
	{
		//Incluyo la configuración del formulario en cuestión.
		include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/config/'.$_POST['form'].'.php';

		//Url de acción con caché para recargar el destino.
		$url=$action.'?cache='.$_SESSION['cache'].$ancla;
		?>
			<html>
				<head>
					<meta charset="utf-8" />

					<!--::::::Includes comunes a todos los formularios::::::-->
					<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
					<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
					<link rel="stylesheet" type="text/css" href="../forms/forms.css" />

					<!--::::::Includes variables pasados por parametro::::::-->
					<?php
						$iMax=count($includes);
						for($i=0;$i<$iMax;$i++)
						{
							//echo '<pre>Include'.$includes[$i].'</pre>';
							head_include($includes[$i]);
						}
						unset($iMax);
					?>

				</head>
				<body>
					<form method="POST" class="tresem nuevo" action="<?php echo $url ?>">
						<?php

							$iMax=$cantidad;

							for($i=0;$i<$iMax;$i++)
							{
								$autocomp=[];

								if(isset($_POST['edita']) && isset($_POST['conID']))
								{
									$conIDAct=$_POST['conID'][$i];
									include $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/forms/config/'.$_POST['form'].'Autocomp.php';
								}

								echo crea_form($labels , $autocomp);
								?>
									<div class="clearfix fin"></div>
								<?php
							}

							unset($cantidad , $i , $iMax);

						?>
						<input type="submit" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" name='<?php echo $for ?>' value="Aceptar">
					</form>
					<div class="clearfix"></div>
				</body>
			</html>
		<?php
	}
}
?>