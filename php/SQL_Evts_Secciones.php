<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';

	error_reporting(-1);
	ini_set('display_errors', 'On');

	class SQL_Evts_Secciones implements SQL_Evts_List
	{
		public function nuevo()
		{
			return $this->edita();
		}
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Seccion.php';
			global $con;

			$edita=isset($_SESSION['accion']) && $_SESSION['accion']==='edita';
			$nSec=new Seccion();

			if(isset($_POST['Modulo']))
			{
				$nSec->ModuloID=intVal($_POST['Modulo']);
			}
			if(!empty($_POST['Titulo'][0]))
			{
				$nSec->HTMLID=htmlentities($_POST['Titulo'][0]);
			}

			if(isset($_POST['Descripcion']))
			{
				if($edita)
				{
					$nSec->ContenidoID=fetch_all
					(
						$con->query
						(
							'	SELECT ContenidoID
								FROM Secciones
								WHERE ID='.$_SESSION['conID']
						),
						MYSQLI_NUM
					)[0][0];

					include($_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php');

					updTraduccion($_POST['Descripcion'][0] , $nSec->ContenidoID , $_SESSION['lang']);
				}
				else
				{
					include($_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php');

					$descripcion=nTraduccion($_POST['Descripcion'][0] , $_SESSION['lang']);

					$descripcion->insSQL();

					$nSec->ContenidoID=$descripcion->ContenidoID;
				}
			}

			if(isset($_POST['Modulo']) || isset($_POST['Descripcion']))
			{
				if($edita)
				{
					$nSec->PadreID=fetch_all
					(
						$con->query
						(
							'	SELECT PadreID
								FROM Secciones
								WHERE ID='.$_SESSION['conID']
						),
						MYSQLI_NUM
					)[0][0];	
				}
				else
				{
					$nSec->PadreID=$_SESSION['conID'];
				}
				

				$condicion=' PadreID='.$nSec->PadreID;
			}
			else
			{
				$condicion=' ContenidoID IS NULL AND ModuloID IS NULL';
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

			$nSec->Visible=$_POST['Visible'][0];
			$nSec->Prioridad=reordena($_POST['Lugar'] , $nSec , $condicion , $edita);

			if($edita)
			{
				$nSec->updSQL(false,['ID'=>$_SESSION['conID']]);
			}
			else
			{
				$nSec->insSQL();
			}

			$afectados=[$_SESSION['conID']];

			if($nSec->HTMLID!==NULL && $_POST['Agregar_al_menu'][0]==='1')
			{
				global $con,$afectado;

				include($_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php');
				$menu=new Menu(['SeccionID'=>$nSec->HTMLID]);

				$menu->getSQL();

				if(empty($menu->ID))
				{
					include_once($_SERVER['DOCUMENT_ROOT'] . '//php/nTraduccion.php');
					include_once($_SERVER['DOCUMENT_ROOT'] . '//php/Foranea.php');

					$menu->Prioridad=fetch_all($con->query('select max(Prioridad) from Menu') , MYSQLI_NUM)[0][0];
					$menu->Url='#'.rawurlencode($_POST['Titulo'][0]);

					$menu->insForanea
					(
						nTraduccion
						(
							$_POST['Titulo'][0],
							$_SESSION['lang']
						),
						'ContenidoID',
						'ContenidoID'
					);

					$menu->insSQL();
				}
			}
			return [$nSec->ID];
		}
		public function elimina()
		{

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

			$tipo=isset($_SESSION['conID']);
			$secID=NULL;

			if($tipo)
			{
				$contenidoID=fetch_all
				(
					$con->query('SELECT ContenidoID FROM Secciones WHERE ID='.$_SESSION['conID']),
					MYSQLI_NUM
				)[0][0];

				if($contenidoID!==NULL)
				{
					//Existe una relacion ON DELETE CASCADE entre las tablas 
					//secciones->contenidos y traducciones->contenidos, de manera
					//que eliminando el contenido, automáticamente se elimina la sección
					//y las traducciones relacionadas.
					$con->query('DELETE FROM Contenidos WHERE ID='.$contenidoID);
				}
				else
				{
					$secID=$_SESSION['conID'];
				}
			}
			else
			{
				$secID=$_SESSION['conID'];
			}
			if($secID!==NULL)
			{
				$con->query('DELETE FROM Secciones WHERE ID='.$secID);
			}
		}
	}

?>