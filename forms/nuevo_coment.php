<form class="nComentForm" action="visor.php#comRes" method="POST">
	<p>Nombres:</p>
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
	<p>Mensaje:</p>
	<textarea id="#editor" name="comContenido" cols="20" rows="4"></textarea>
	<input type="submit" value="Publicar" >
</form>