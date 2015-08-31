<div class="overhidden">
	<?php
		
		if(isset($this->autocomp['Imagen']))
		{
			$selected=$this->autocomp['Imagen'];
		}
		else
		{
			if(isset($Imgs[0]))
			{
				$selected=$Imgs[0]['ID'];
			}
		}

		for($i=0;$i<$cantidad;$i++)
		{
			$Img=$Imgs[$i];
			?>
				<div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
					<input name="Imagen[]" type="radio" value="<?php echo $Img['ID'] ?>" <?php if($Img['ID']==$selected){echo 'checked="checked"';}?> >
					<img src="/img/miniaturas/galeria/<?php echo $Img['ID']?>.png" >
				</div>
			<?php
		}
	?>
</div>