<?php
include_once('head_include.php');
//Construyo el formulario con la configuración dada y lo devuelvo como string.
function crea_form($labels)
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

			<?php include('../forms/'.$tipo); ?>

			<div class="clearfix"></div>

		<?php

		$buff=$buff.ob_get_contents();
		ob_end_clean();
	}

	unset($l , $labelName , $labelAct , $labels);

	return $buff;
}
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	$_SESSION['cantidad']=1;

	if(isset($_POST['cantidad']))
	{
		$_SESSION['cantidad']=$_POST['cantidad'];
	}
	
	if( isset($_POST['nuevas'])	&& isset($_POST['form']) )
	{
		//Incluyo la configuración del formulario en cuestión.
		include ('../forms/config/'.$_POST['form'].'.php');

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
							head_include($includes[$i]);
						}
						unset($iMax);
					?>

				</head>
				<body>
						<form method="POST" class="tresem nuevo" action="<?php echo $url ?>">
						<?php

							$buff=crea_form($labels);

							$iMax=$_SESSION['cantidad'];
							for($i=0;$i<$iMax;$i++)
							{
								echo $buff;

								?>
									<div class="clearfix fin"></div>
								<?php
							}

							unset($_SESSION['cantidad'] , $i , $iMax);

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