<div class="overhidden">
	<?php
		include_once '../php/conexion.php';

		$Imgs=$con->query('select * from Imagenes where 1');
		$Imgs=fetch_all($Imgs , MYSQLI_ASSOC);

		$cantidad=count($Imgs);
		if(isset($autocomp['Imagen']))
		{
			$selected=$autocomp['Imagen'];
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
					<img src="<?php echo $Img['Url']?>" >
				</div>
			<?php
		}
	?>
</div>