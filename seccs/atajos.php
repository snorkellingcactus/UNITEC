<?php
	$accesKey='[Alt]';

	$navStrings=
	[
		'Firefox'	=>'[Alt] [Shift]',
		'Mac OS X'	=>'[Control] [Alt]'
	];

	$agent=$_SERVER['HTTP_USER_AGENT'];

	foreach($navStrings as $clave=>$valor)
	{
		if(strrpos($agent,$clave)!==FALSE)
		{
			$accesKey=$valor;
		}
	}
?>
<section class="portada" id="atajos">

	<h1>Atajos</h1>
	<table class="table table-condensed2">
		<tr>
			<td>
				<b>Inicio</b>
			</td>
			<td>
				<span class="atajo"><?php echo $accesKey ?></span>
				<span class="mas">+</span>
				<span class="atajo">I</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Novedades</b>
			</td>
			<td>
				<span class="atajo"><?php echo $accesKey ?></span>
				<span class="mas">+</span>
				<span class="atajo">N</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Expacio de extensión</b>
			</td>
			<td>
				<span class="atajo"><?php echo $accesKey ?></span>
				<span class="mas">+</span>
				<span class="atajo">L</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Novedades</b>
			</td>
			<td>
				<span class="atajo"><?php echo $accesKey ?></span>
				<span class="mas">+</span>
				<span class="atajo">C</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Galeria</b>
			</td>
			<td>
				<span class="atajo"><?php echo $accesKey ?></span>
				<span class="mas">+</span>
				<span class="atajo">G</span>
			</td>
		</tr>		
	</table>
</section>