<div class="overhidden">
	<?php
		include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
		global $con;

		$Imgs=$con->query
		(
			'	SELECT Imagenes.*
				FROM Imagenes
				WHERE 1
				ORDER BY Prioridad
			'
		);
		$Imgs=fetch_all($Imgs , MYSQLI_ASSOC);

		$cantidad=count($Imgs);
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