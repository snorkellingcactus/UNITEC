<form class="nComentForm tresem" action="#targeted" method="POST"
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
	<label for="comNomUsuario"><?php echo gettext('Nombres:')?></label>
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
	<label for="comContenido"><?php echo gettext('Mensaje:')?></label>
	<textarea id="#editor" name="comContenido" cols="20" rows="4"></textarea>
	<input type="submit" name="Continuar" value="<?php echo gettext('Publicar')?>" >
</form>