<form id="<?php echo 'acciones'.$fId ?>" method="POST" action="php/accion.php" target="_blank">
<input type="hidden" name="form" value="<?php echo 'acciones'.$fId ?>" >
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
</form>
<?php

?>