<form class="nComentForm tresem" action="<?php echo basename($_SERVER['SCRIPT_FILENAME']) ?>#comRes" method="POST"
	<?php
		if(isset($_POST['comConID']))
		{
			?>
			id="comRes"
			<?php
		}
	?>
>
	<input type="hidden" name="form" value="accionesCom"/>
	<input type="hidden" name="nuevo" value="accionesCom"/>
	<p><?php echo gettext('Nombres:')?></p>
	<input type="text" name="comNomUsuario" >

	<?php
		if(isset($_SESSION['comNomUsuario']))
		{
			if(isset($_SESSION['adminID']))
			{
				?>
					<p class='comNomAdmin'> <?php echo $_SESSION['comNomUsuario'] ?></p>
				<?php
			}
		}
	?>
	<p><?php echo gettext('Mensaje:')?></p>
	<textarea id="#editor" name="comContenido" cols="20" rows="4"></textarea>
	<input type="submit" name="Continuar" value="<?php echo gettext('Publicar')?>" >
</form>