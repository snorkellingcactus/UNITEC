<div>
	<p class='comAutor'>
		<?php echo $esq->NombreUsuario ?>
		 Dijo:

		 <?php
			 if(isset($_POST['comRes'])&&$_POST['comResID']==$esq->ID)
			 {
			 	$_SESSION['comResID']=$_POST['comResID'];

			 	echo file_get_contents("../forms/nuevo_coment.php");
			 }
		 ?>
	</p>
	<?php
		if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
		 {
		 	?>
			 	<input type="checkbox" name="comID[]" value="<?php echo $esq->ID ?>" form="comForm">
		 	<?php
		 }
	?>

 	<input type="hidden" name="comResID" form="comForm" value="<?php echo $esq->ID ?>" >
 	<input type="submit" name="comRes" form="comForm" value="↶">

	<p class="comCont">
		<?php echo $esq->Contenido ?>
	</p>
</div>