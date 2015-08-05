<?php
	$accesKey=[	'[Alt]'	];

	$navStrings=
	[
		'Firefox'	=>[	'Alt'		,	'Shift'	],
		'Mac OS X'	=>[	'Control'	,	'Alt'	]
	];

	$agent=$_SERVER['HTTP_USER_AGENT'];

	foreach($navStrings as $clave=>$valor)
	{
		if(strrpos($agent,$clave)!==FALSE)
		{
			$accesKey=$valor;
		}
	}


	ob_start();

	$iMax=count($accesKey);

	for($i=0;$i<$iMax;$i++)
	{
		?>
			<span class="atajo"><?php echo $accesKey[$i]?></span>
			<span class="mas">+</span>
		<?php
	}
	$accesStr=ob_get_contents();
	ob_end_clean();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php');
	global $con;

	$atajos=fetch_all
	(
		$con->query
		(
			'	SELECT Menu.Atajo , Menu.ContenidoID, Menu.SeccionID, Menu.Url
				FROM Menu
				WHERE Atajo IS NOT NULL
			'
		),
		MYSQLI_ASSOC
	);
?>
<div>
	<table class="table atajos" >
		<?php
			$iMax=count($atajos);
			for($i=0;$i<$iMax;$i++)
			{
				$atajo=$atajos[$i];
				?>
					<tr>
						<td>
							<b>
								<?php echo getTraduccion($atajo['ContenidoID'],$_SESSION['lang']); ?>
							</b>
						</td>
						<td>
							<?php echo $accesStr ?>
							<span class="atajo">
								<?php echo $atajo['Atajo']?>
							</span>
						</td>
					</tr>
				<?php
			}
		?>
	</table>
</div>