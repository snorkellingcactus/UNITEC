<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	if(isset($fId))
	{
		$fNom=$fId;
		$fId='id="acciones'.$fId.'"';
	}
	else
	{
		if(!isset($fNom))
		{
			$fNom='';
		}
		$fId='class="sinId"';
	}
	if(!isset($fType))
	{
		$fType=$fNom;
	}

	$raiz='http://' . $_SERVER['SERVER_NAME'] . '/Web/Pasantía/edetec/';
	?>
		<form <?php echo $fId ?> method="POST" action="<?php echo $raiz?>php/accion.php">
		<input type="hidden" name="form" value="<?php echo 'acciones'.$fType ?>" >
		<p class="acciones">Selecci&oacute;n:
				<input type="submit" name="elimina" value="Eliminar">
				<input type="submit" name="edita" value="Editar">
		</p>
		<?php

		if(!isset($omitirNuevas))
		{
		?>
		<p class="acciones">Acciones:
			<?php
			if($cMax)
			{
				$submitTxt='Nuevas';
			?>
			<select name="cantidad">
				<?php
					for($i=1;$i<=$cMax;$i++)
					{
						?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
					}
				?>
			</select>
			<?php
			}
			else
			{
				$submitTxt='Nueva';
			}
			?>
			<input type="submit" name="nuevas" value="<?php echo $submitTxt ?>">
		</p>
		<?php } ?>
		</form>
	<?php
	unset($fType);
}