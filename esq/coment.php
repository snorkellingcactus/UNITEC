
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
		 if(isset($_POST['comResID'])&&$_POST['comResID']==$esq->ID)
		 {
		 	$_SESSION['comResID']=$_POST['comResID'];

		 	echo file_get_contents("../forms/nuevo_coment.php");
		 }
		 ?>
	</p>
	<form action="visor.php" method="POST">
		 	<input type="hidden" name="comResID" value="<?php echo $esq->ID ?>" >
		 	<input type="submit" value="↶" >
	</form>
	<p class="comCont">
		<?php echo $esq->Contenido ?>
	</p>
</div>