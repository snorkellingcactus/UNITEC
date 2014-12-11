<div>
	<p class='comAutor'>
		<?php echo $esq->NombreUsuario ?>
		 Dijo:
		 <?php
		 if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
		 {
		 	?>
		 		<a href="?eComID=<?php echo $esq->ID ?>#gal" >X</a>
		 	<?php
		 }

		 ?>
	</p>
	<p>
		<?php echo $esq->Contenido ?>
	</p>
</div>