<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

if(isset($_SESSION['adminID']))
{
	if(isset($this->fId))
	{
		$this->fNom=$this->fId;
		$this->fId='id="acciones'.$fId.'"';
	}
	else
	{
		if(!isset($this->fNom))
		{
			$this->fNom='';
		}
		$this->fId='class="sinId"';
	}
	if(!isset($this->fType))
	{
		$this->fType=$this->fNom;
	}

	$raiz='http://' . $_SERVER['SERVER_NAME'] . '/Web/Pasantía/edetec/';
	?>
		<form <?php echo $this->fId ?> method="POST" action="<?php echo $raiz?>php/accion.php">
		<input type="hidden" name="form" value="<?php echo 'acciones'.$this->fType ?>" >
		<p class="acciones">Selecci&oacute;n:
				<input type="submit" name="elimina" value="Eliminar">
				<input type="submit" name="edita" value="Editar">
		</p>
		<?php

		if(!isset($this->omitirNuevas))
		{
		?>
		<p class="acciones">Acciones:
			<?php
			if($this->cMax)
			{
				$submitTxt='Nuevas';
			?>
			<select name="cantidad">
				<?php
					for($i=1;$i<=$this->cMax;$i++)
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
}