<?php
	$tiempos=['Año','Mes','Dia','Horas','Minutos'];
	$jMax=count($tiempos);
?>
<div class="fecha col-xs-12 col-sm-8 col-md-8 col-lg-8">
	<?php
	for($j=0;$j<$jMax;$j++)
	{
		$fix=$tAct=$tiempos[$j];
		
		$cols='col-xs-12 col-sm-4 col-md-4 col-lg-4';
		if($j)
		{
			$cols='col-xs-12 col-sm-2 col-md-2 col-lg-2';
		}
		else
		{
			$fix='Ano';
		}
		?>
			<div class="<?php echo $cols ?>">
				<label for="<?php echo $tAct ?>"><?php echo $tAct ?></label>
				<input type="number" name="<?php echo $fix ?>[]"/>
			</div>
		<?php
	}
	?>
</div>