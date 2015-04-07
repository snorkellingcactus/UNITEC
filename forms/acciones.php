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
	?>
		<form <?php echo $fId ?> method="POST" action="php/accion.php" target="_blank">
		<input type="hidden" name="form" value="<?php echo 'acciones'.$fNom ?>" >
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
}