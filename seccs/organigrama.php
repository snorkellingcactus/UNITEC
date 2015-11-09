<div class="clearfix"></div>
<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMOrganigrama.php';

	//$formLab=new FormCliLab('accionesLab');
	if(isset($_SESSION['adminID']))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

		//Revisar.Solución temporal.
		$lab=$_SESSION['lab'];
		detectLab();
		if($lab!==$_SESSION['lab'])
		{
			header('Location: /');
			die();
		}
	}

	$organigrama=new DOMOrganigrama();
	
	global $con;
	
	if($_SESSION['lab']!==false)
	{
		$labs=fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.ID, Laboratorios.PadreID, Laboratorios.Color, Laboratorios.Enlace, Laboratorios.NombreID, Traducciones.Texto
					FROM Laboratorios
					LEFT OUTER JOIN Traducciones
					ON Traducciones.ContenidoID=Laboratorios.NombreID
					WHERE Laboratorios.ID='.$_SESSION['lab'].'
					LIMIT 1
				'
			),
			MYSQLI_ASSOC
		);

		function arbolLabs($labs , $organigrama , $con , $padreID)
		{
			$organigrama->solveDeps($labs , $padreID);

			$i=0;
			while(isset($labs[$i]) && $i<15)
			{
				$childs=fetch_all
				(
					$con->query
					(
						'	SELECT Laboratorios.ID, Laboratorios.PadreID, Laboratorios.Color, Laboratorios.Enlace, Laboratorios.NombreID, Traducciones.Texto
							FROM Laboratorios
							LEFT OUTER JOIN Traducciones
							ON Traducciones.ContenidoID=Laboratorios.NombreID
							WHERE Laboratorios.PadreID='.$labs[$i]['ID']
					),
					MYSQLI_ASSOC
				);

				if(isset($childs[0]))
				{
					arbolLabs($childs , $organigrama , $con , $padreID);
				}

				++$i;
			}
		}
		//$organigrama->solveDeps($labs , null);
		arbolLabs($labs , $organigrama , $con , $labs[0]['PadreID']);

		echo $organigrama->getHTML();
	}
	else
	{
		if(isset($_SESSION['adminID']))
		{
			?>
				<p>
					<?php echo gettext('No se creó ningun laboratorio. Quizá desee <a href="/php/accion.php?form=accionesLab&accion=nuevo" >crear uno nuevo</a>')?>
				</p>
			<?php
		}
	}
?>
