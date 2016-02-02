<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMInclude.php';

	class Modulo_Organigrama extends DOMInclude
	{
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
					$this->arbolLabs($childs , $organigrama , $con , $padreID);
				}

				++$i;
			}
		}
		function renderChilds(&$doc , &$tag)
		{
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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMOrganigrama.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

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
				
				//$organigrama->solveDeps($labs , null);
				$this->arbolLabs($labs , $organigrama , $con , $labs[0]['PadreID']);

				$this->appendChild
				(
					$organigrama
				);
			}
			else
			{
				if(isset($_SESSION['adminID']))
				{
					$p=new DOMTag('p' , 'No se creó ningun laboratorio. Quizá desee ');
					$link=new DOMLink();

					$this->appendChild
					(
						$p->appendChild
						(
							$link
							->setUrl('/php/accion.php?form=accionesLab&accion=nuevo')
							->setName('crear uno nuevo')
						)
					);
				}
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>
