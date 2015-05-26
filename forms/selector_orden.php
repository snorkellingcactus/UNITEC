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
		$autocompOrden=false;
		if(isset($orden))
		{
			if(isset($autocomp[$labelName]) && count($orden)>$autocomp[$labelName])
			{
				$autocompOrden=$autocomp[$labelName];
			}
			for($j=0;$j<$jMax;$j++)
			{
				?>
					<option value="t<?php echo $j?>" <?php if($autocompOrden!==false && $autocompOrden==$j){ ?> selected="selected" <?php } ?> ></option>
					<option class="lleno"><?php echo $j?></option>
				<?php
			}
		}
	?>
	<option value="b" <?php if($autocompOrden===false){ ?> selected="selected"<?php }?> ></option>
</select>