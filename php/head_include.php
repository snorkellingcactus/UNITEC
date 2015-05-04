<?
	function head_include($str)
	{
		$pos=strrpos( $str , '.');

		if($pos)
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

		unset($pos , $tipo , $str);
	}
	//Incluyo los tags <link> y <script> según un array con rutas de archivos.
?>