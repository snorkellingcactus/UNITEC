<!DOCTYPE html >
<?php
//Solo si se está en modo administrador.
if(isset($_SESSION['adminID']))
{
	include_once 'php/conexion.php';
	include_once 'php/SQL_DOM.php';

	$usuario=$con->query('select * from Usuarios where ID='.$_SESSION['adminID']);
	$usuario=$usuario->fetch_all(MYSQLI_ASSOC)[0];
?>

<div class 'panelAdmin'>
	<script type="text/javascript" src="js/Caja.js"></script>
	<script type="text/javascript" src="js/Diag.js"></script>
	<script type="text/javascript" src="js/XMLObj.js"></script>
	<script type="text/javascript" src="js/CajaProto.js"></script>
	<script type="text/javascript" src="js/PanelAdmin.js"></script>
	<script type="text/javascript">
	document.body.appendChild
	(
		new Caja
		(
			{
				tag:'div',
				forma:
				{
					style:
					[
						['clear','both'],
						['minWidth','1px']
					]
				}
			}
		).doc
	)

	panel=new PanelAdmin();
	panel.getConf();

	document.body.appendChild(panel.diag.caja('panel').doc);

	</script>
	<h1>Bienvenido <?php echo $usuario['Nombre'] ?></h1>
</div>

<?php
}
?>