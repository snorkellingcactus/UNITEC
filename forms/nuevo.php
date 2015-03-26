<?php
	if(session_status()==PHP_SESSION_NONE)
	{
		session_start();
	}

	$cache=$_SESSION['cache'];

//$includes, $action , $ancla , $for, $labels
//$labels[{tipo:'text',}]

	$url=$action.'?cache='.$_SESSION['cache'].$ancla;
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor.css" />
		<link rel="stylesheet" type="text/css" href="../seccs/visor_form.css" />

		<meta charset="utf-8" />

		<?php
			$iMax=count($includes);
			for($i=0;$i<$iMax;$i++)
			{
				$str=$includes[$i];
				$pos=strrpos( $str , '.');

				if($pos!==false)
				{
					$tipo=substr($str , $pos+1);

					switch($tipo)
					{
						case 'css':
						?>
							<link rel="stylesheet" type="text/css" href="<?php echo $str?>" />
						<?
						break;
						case 'js':
						?>
							<script type="text/javascript" src="<?php echo $str ?>"></script>
						<?php
					}
				}
			}
		?>
	</head>
	<body>

			<form method="POST" action="<?php echo $url ?>" target="_parent">
			<?php
				$iMax=$_SESSION['cantidad'];
				$lMax=count($labels);

				$buff='';
				for($l=0;$l<$lMax;$l++)
				{
					$labelAct=$labels[$l];

					$tipo=$labelAct[0];
					$labelName=$labelAct[1];

					ob_start();

					include('labels.php');

					$buff=$buff.ob_get_contents();
					ob_end_clean();
				}

				for($i=0;$i<$iMax;$i++)
				{
					echo $buff;

					?>
					<div class="clearfix fin"></div>
					<?
				}
			unset($_SESSION['cantidad']);

			?>
			<button type="submit" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" name='<?php echo $for ?>'>Aceptar</button>

			<a href="<?php echo $url ?>" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" target="_parent">Cancelar</a>
		</form>
	</body>
</html>