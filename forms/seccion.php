<?php
if(isset($_SESSION['adminID']))
{
	?>
		<form action="index.php" method="POST">
			<input type="hidden" name="form" value="accionesSec">
			<input type="hidden" name="secID" value="<?php echo $incAct['css_id']['Valor']?>">
			<input type="submit" name="elimina" value="Eliminar">
		</form>
	<?php
}
?>