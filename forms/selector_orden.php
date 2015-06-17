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
		$this->autocompOrden=false;
		if(isset($orden))
		{
			if(isset($this->autocomp[$labelName]) && count($orden)>$this->autocomp[$labelName])
			{
				$this->autocompOrden=$this->autocomp[$labelName];
			}
			for($j=0;$j<$jMax;$j++)
			{
				$nombre=$j;
				if(!empty($orden[$j][0]))
				{
					$nombre=$orden[$j][0];
				}
				?>
					<option value="t<?php echo $j?>" <?php if($this->autocompOrden!==false && $this->autocompOrden==$j){ ?> selected="selected" <?php } ?> ></option>
					<option class="lleno"><?php echo $nombre?></option>
				<?php
			}
		}
	?>
	<option value="b" <?php if($this->autocompOrden===false){ ?> selected="selected"<?php }?> ></option>
</select>