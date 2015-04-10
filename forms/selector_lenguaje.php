<select name="Lenguaje[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
	<?php
		include_once('../php/conexion.php');

		$consulta=$con->query('select * from Lenguajes');
		$consulta=fetch_all($consulta , MYSQLI_ASSOC);

		$jMax=count($consulta);

		for($j=0;$j<$jMax;$j++)
		{
			?>
				<option value="<?php echo $consulta[$j]['ID'] ?>"><?php echo $consulta[$j]['Nombre'] ;?></option>
			<?php
		}
	?>
</select>