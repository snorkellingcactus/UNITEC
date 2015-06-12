<?php
	$tiempos=['Año','Mes','Dia','Horas','Minutos'];
	$times=['Y','m','d','H','i','s'];
	$jMax=count($tiempos);
	if(isset($this->autocomp[$labelName]))
	{
		$fecha=$this->autocomp[$labelName];
		$fecha=new DateTime($fecha);
	}
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
				<input type="number" name="<?php echo $fix ?>[]" 
				<?php
					if(isset($fecha))
					{
						?>
						 value="<?php echo $fecha->format($times[$j]);?>"
						<?php
					}
				?>
				>
			</div>
		<?php
	}
	?>
</div>