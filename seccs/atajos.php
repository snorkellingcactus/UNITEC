<?php
	$accesKey=[	'[Alt]'	];

	$navStrings=
	[
		'Firefox'	=>	[gettext('Alt')		,	gettext('Shift')],
		'Mac OS X'	=>	[gettext('Control')	,	gettext('Alt')	]
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

	$condVisible='';
	if(!isset($_SESSION['adminID']))
	{
		$condVisible='AND Secciones.Visible=1';
	}

	$atajos=fetch_all
	(
		$con->query
		(
			'	SELECT Menu.Atajo , Menu.ContenidoID, Menu.SeccionID
				FROM Menu
				LEFT OUTER JOIN Secciones
				ON Secciones.HTMLID=Menu.SeccionID '.$condVisible.'
				LEFT OUTER JOIN TagsTarget
				ON TagsTarget.GrupoID=Secciones.TagsGrpID
				LEFT OUTER JOIN Laboratorios
				ON Laboratorios.ID='.$_SESSION['lab'].'
				WHERE TagsTarget.TagID=Laboratorios.TagID
				AND Menu.Atajo IS NOT NULL
			'
		),
		MYSQLI_ASSOC
	);
?>
<div>
	<!-- summary="Atajos de teclado" -->
	<table class="table atajos">
		<thead>
			<tr>
				<th><?php echo gettext('Sección')?></th>
				<th><?php echo gettext('Teclas')?></th>
			</tr>
		</thead>
		<tbody>
			<!-- Revisar -->
			<tr>
				<!-- scope="col" -->
				<td >
					<b>
						<?php echo gettext('Inicio')?>
					</b>
				</td>
				<!-- scope="col" -->
				<td>
					<?php echo $accesStr ?>
					<span class="atajo">
						I
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
							<!-- scope="col" -->
							<td>
								<b>
									<?php echo getTraduccion($atajo['ContenidoID'],$_SESSION['lang']); ?>
								</b>
							</td>
							<!-- scope="col" -->
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
		</tbody>
	</table>
</div>