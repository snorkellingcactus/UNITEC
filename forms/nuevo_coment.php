<form class="nComentForm" action="visor.php#gal" method="POST">
	<p>Comentá:</p>
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
	<p> Nombre: 
		<input type="text" name="comNomUsuario" defaultValue='Anónimo' >
	</p>
	<input type="text" name="comContenido" >
	<input type="submit" value="Ok" >
</form>