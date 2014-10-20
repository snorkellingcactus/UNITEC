<!DOCTYPE html >
<?php
//Solo si se está en modo administrador.
if(isset($_SESSION['adminID']))
{
	include_once 'php/conexion.php';

	$usuario=$con->query('select * from Usuarios where ID='.$_SESSION['adminID']);
	$usuario=$usuario->fetch_all(MYSQLI_ASSOC)[0];
?>

<div class 'panelAdmin'>
	<h1>Bienvenido <?php echo $usuario['Nombre'] ?></h1>
	<h2>Acá iría el panel de administración</h2>
	<a href='inicio_sesion.php?cSesion'>Cerrar Sesión</a>
</div>

<?php
}
?>