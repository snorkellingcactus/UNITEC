<?php
	$accesKey=[	'[Alt]'	];

	$navStrings=
	[
		'Firefox'	=>[	'[Alt]'		,	'[Shift]'	],
		'Mac OS X'	=>[	'[Control]'	,	'[Alt]'		]
	];

	$agent=$_SERVER['HTTP_USER_AGENT'];

	foreach($navStrings as $clave=>$valor)
	{
		if(strrpos($agent,$clave)!==FALSE)
		{
			$accesKey=$valor;
		}
	}

	$iMax=count($accesKey);
	$accesStr='';
	for($i=0;$i<$iMax;$i++)
	{
		$accesStr=$accesStr.'<span class="atajo">'.$accesKey[$i].'</span><span class="mas">+</span>';
	}
?>
<span class="hidden-xs">
<div class="portada" id="atajos">

	<h1>Atajos</h1>
	<table class="table" >
		<tr>
			<td>
				<b>Inicio</b>
			</td>
			<td>
				<?php echo $accesStr ?>
				<span class="atajo">I</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Novedades</b>
			</td>
			<td>
				<?php echo $accesStr ?>
				<span class="atajo">N</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Expacio de extensión</b>
			</td>
			<td>
				<?php echo $accesStr ?>
				<span class="atajo">L</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Novedades</b>
			</td>
			<td>
				<?php echo $accesStr ?>
				<span class="atajo">C</span>
			</td>
		</tr>
		<tr>
			<td>
				<b>Galeria</b>
			</td>
			<td>
				<?php echo $accesStr ?>
				<span class="atajo">G</span>
			</td>
		</tr>		
	</table>
</div>
</span>