<?php
$jMax=0;
	if(isset($_POST['lleno']))
	{
		$orden=$_POST['lleno'];

		$jMax=count($orden);
	}
?>
<select name="<?php echo $labelName ?>" class="orden col-xs-12 col-sm-8 col-md-8 col-lg-8" size="<?php echo $jMax*2+1?>">
	<?php
		if(isset($orden))
		{
			for($j=0;$j<$jMax;$j++)
			{
				?>
					<option value="<?php echo 't'.$j?>"></option>
					<option class="lleno"><?php echo $j?></option>
				<?php
			}
		}
	?>
	<option value="b" selected="selected"></option>
</select>