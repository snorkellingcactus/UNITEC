<form class="nComentForm" action="visor.php#gal" method="POST">
	<p>Nombres:</p>
	<input type="text" name="comNomUsuario" >

	<?php
		if(isset($_SESSION['comNomUsuario']))
		{
			if(isset($_SESSION['adminID']))
			{
				?>
					<p class='comNomAdmin'> <?php echo $_SESSION['comNomUsuario'] ?></p>
				<?
			}
		}
	?>
	<p>Mensaje:</p>
	<textarea name="comContenido" cols="20" rows="4"></textarea>
	<input type="submit" value="Publicar" >
</form>