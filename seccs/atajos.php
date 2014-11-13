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
		<tr><td><b>	Inicio				</b></td><td>	<?php echo $accesKey ?> + I</td></tr>
		<tr><td><b>	Novedades			</b></td><td>	<?php echo $accesKey ?> + N</td></tr>
		<tr><td><b>	Expacio de extensión</b></td><td>	<?php echo $accesKey ?> + L</td></tr>
		<tr><td><b>	Novedades			</b></td><td>	<?php echo $accesKey ?> + C</td></tr>
		<tr><td><b>	Galeria				</b></td><td>	<?php echo $accesKey ?> + G</td></tr>		
	</table>

</section>