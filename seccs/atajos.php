<?php
	$accesKey=[	'[Alt]'	];

	$navStrings=
	[
		gettext('Firefox')	=>	[gettext('Alt')		,	gettext('Shift')],
		gettext('Mac OS X')	=>	[gettext('Control')	,	gettext('Alt')	]
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
	<table class="table atajos" summary="Atajos de teclado">
		<thead>
			<th><?php echo gettext('Sección')?></th>
			<th><?php echo gettext('Teclas')?></th>
		</thead>
		<tbody>
			<!-- Revisar -->
			<tr>
				<td scope="col">
					<b>
						<?php echo gettext('Inicio')?>
					</b>
				</td>
				<td scope="col">
					<?php echo $accesStr ?>
					<span class="atajo">
						i
					</span>
				</td>
			</tr>
			<?php
				$iMax=count($atajos);
				for($i=0;$i<$iMax;$i++)
				{
					$atajo=$atajos[$i];
					?>
						<tr>
							<td scope="col">
								<b>
									<?php echo getTraduccion($atajo['ContenidoID'],$_SESSION['lang']); ?>
								</b>
							</td>
							<td scope="col">
								<?php echo $accesStr ?>
								<span class="atajo">
									<?php echo $atajo['Atajo']?>
								</span>
							</td>
						</tr>
					<?php
				}
			?>
		</tbody>
	</table>
</div>