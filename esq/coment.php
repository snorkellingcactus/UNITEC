<?php
	if
	(
		(isset($_POST['comResID'])&&$_POST['comResID']==$esq->ID) ||
		isset($_SESSION['comRes'])
	)
	{
		unset($_SESSION['comRes']);
		?>
			<span id="comRes"></span>
		<?php
	}
?>
<div class="comentario">
	<p class='comAutor'>
		<?php
			echo $esq->NombreUsuario;

			if(isset($esq->NombreDest))
			{
				?>
					<span class="comResTxt">&#8631; <?php echo $esq->NombreDest ?></span>
				<?php
			}
		?>
	</p>

	<form action="#comRes" method="POST" class="formRes">
		<input type="hidden" name="comResID" value="<?php echo $esq->ID ?>" >
	 	<input type="submit" value="↶" title="Responder a <?php echo $esq->NombreUsuario ?>">
	</form>

 	<?php
		if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
		 {
		 	?>
			 	<input type="checkbox" name="comID[]" value="<?php echo $esq->ID ?>" form="accionesCom">
		 	<?php
		 }
	?>


	<p class="comCont">
		<?php echo $esq->Contenido ?>
	</p>

	<?php
		if(isset($_POST['comResID'])&&$_POST['comResID']==$esq->ID)
		{
			$_SESSION['comResID']=$_POST['comResID'];
			echo file_get_contents("../forms/nuevo_coment.php");
		}
	?>
</div>