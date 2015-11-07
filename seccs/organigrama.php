<div class="clearfix"></div>
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMOrganigrama.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliLab.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Labs.php';

	//$formLab=new FormCliLab('accionesLab');

	$formLab=new FormCliRecv('Lab');
	$formLab->SQL_Evts=new SQL_Evts_Labs();
	$formLab->checks();
	
	global $con;
	
	$labs=fetch_all
	(
		$con->query
		(
			'	SELECT ID, PadreID, Color, Enlace, NombreID
				FROM Laboratorios
				WHERE Organigrama=1
			'
		),
		MYSQLI_ASSOC
	);

	if(!isset($labs[0]))
	{
		?>
			<p>
				<?php echo gettext('No se creó ningun laboratorio. Quizá desee <a href="/php/accion.php?form=accionesLab&accion=nuevo" >crear uno nuevo</a>')?>
			</p>
		<?php
	}
	else
	{
		$organigrama=new DOMOrganigrama($labs , null);
		echo $organigrama->getHTML();
	}
?>
