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
		<link rel="stylesheet" type="text/css" href="../forms/forms.css" />

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

			<form method="POST" class="tresem nuevo" action="<?php echo $url ?>" target="_parent">
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
			<button type="submit" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" name='<?php echo $for ?>'>Aceptar</button>
		</form>
		<div class="clearfix"></div>
	</body>
</html>