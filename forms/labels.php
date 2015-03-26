<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<label for="<?php echo $labelName ?>"><?php echo $labelName ?>:</label>
</p>
<?php
switch ($tipo)
{
	case 'editor':
	?>
		<div class="clearfix"></div>
		<textarea id="editor" name="Descripcion[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8" rows='7'/></textarea>
	<?php
	break;
	case 'langs':
	?>
		<select name="Lenguaje[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<?php
				include_once('../php/conexion.php');

				$consulta=$con->query('select * from Lenguajes');
				$consulta=$consulta->fetch_all(MYSQLI_ASSOC);

				$jMax=count($consulta);

				for($j=0;$j<$jMax;$j++)
				{
					?>
						<option value="<?php echo $consulta[$j]['ID'] ?>"><?php echo $consulta[$j]['Nombre'] ;?></option>
					<?php
				}
			?>
		</select>
	<?php
	break;
	case 'imgs':
		?>
			<div class="overhidden">
				<?php
					include_once '../php/conexion.php';

					$Imgs=$con->query('select * from Imagenes where 1');
					$Imgs=$Imgs->fetch_all(MYSQLI_ASSOC);

					$cantidad=count($Imgs);

					if($cantidad)
					{

						for($i=0;$i<$cantidad;$i++)
						{
							$Img=$Imgs[$i];
							?>
								<div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
									<input name="Imagen[]" type="radio" value="<?php echo $Img['ID'] ?>" <?php if($i===0){echo 'checked="checked"';}?> />
									<img src="<?php echo $Img['Url']?>" />
								</div>
							<?php
						}
					}
				?>
			</div>
		<?php
	break;
	case 'date':
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
		<?php
	break;
	default:
	?>
		<input type="text" name="<?php echo $labelName ?>[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
	<?
}
?>
<div class="clearfix"></div>
