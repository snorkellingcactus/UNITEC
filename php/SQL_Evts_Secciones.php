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
			$lugar=$_POST['Lugar'];
			$prefijo=$lugar[0];
			$pOrden=intVal(substr($lugar , 1));

			$edita=isset($_SESSION['accion']) && $_SESSION['accion']==='edita';

			//Buscar en el futuro la forma de no repetir este código:
			$inc='';
			$tipo=0;
			$valor=NULL;
			$htmlID=NULL;

			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
			global $con;

			if(isset($_POST['Descripcion']))
			{
				if($edita)
				{
					$valor=fetch_all
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

					updTraduccion($_POST['Descripcion'][0] , $valor , $_SESSION['lang']);
				}
				else
				{
					include($_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php');

					$descripcion=nTraduccion($_POST['Descripcion'][0] , $_SESSION['lang']);

					$descripcion->insSQL();

					$valor=$descripcion->ContenidoID;
				}
				$tipo=2;
			}
			if(isset($_POST['Modulo']))
			{
				$valor=$_POST['Modulo'];
				$tipo=1;
			}
			
			if($edita)
			{
				$padreID=fetch_all
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
				if($tipo!==0)
				{
					$padreID=$_POST['conID'];
				}
			}
			if($tipo!==0)
			{	
				$condicion=' PadreID='.$padreID;
			}
			else
			{
				$condicion=' ContenidoID IS NULL AND ModuloID IS NULL';
			}

			$nOrden=0;

			if($prefijo=='b')
			{
				//El último + 1.
				$nOrden=fetch_all($con->query('select max(Prioridad) from Secciones WHERE'.$condicion) , MYSQLI_NUM)[0][0]+1;
			}
			else
			{
				$secciones=$con->query('SELECT * FROM Secciones WHERE '.$condicion.' ORDER BY Prioridad ASC');
				$secciones=fetch_all($secciones , MYSQLI_ASSOC);
				//Si alguna seccion ocupa el lugar de la nueva la muevo a ella y
				//en el caso de que sea necesario a sus siguientes.

				$j=$pOrden;
				$nOrden=intVal($secciones[$pOrden]['Prioridad']);
				$sMax=count($secciones);

				while($j<$sMax && $secciones[$j]['Prioridad']==($nOrden+$j-$pOrden))
				{

					if($edita && $secciones[$j]['ID']===$_SESSION['conID'])
					{
						$j++;
						continue;
					}
					$nID=$secciones[$j]['ID'];

					$consulta='update Secciones set Prioridad='.(intVal($secciones[$j]['Prioridad'])+1).' where ID='.$nID;

					$con->query($consulta);

					++$j;

					if($j>20)
					{
						die('fail');
					}
				}

				$nOrden=$nOrden;
			}
			if($edita)
			{
				$edita=$_SESSION['conID'];
				$_POST['conID']=$padreID;
			}

			if(!empty($_POST['Titulo'][0]))
			{
				$htmlID=htmlentities($_POST['Titulo'][0]);
			}

			$afectados=
			[
				$this->nSec($_POST['Visible'][0] , $nOrden , $tipo , $valor , $edita , $htmlID)
			];

			if($htmlID!==NULL && $_POST['Agregar_al_menu'][0]==='1')
			{
				global $con,$afectado;

				include($_SERVER['DOCUMENT_ROOT'] . '//php/Menu.php');
				$menu=new Menu(['SeccionID'=>$htmlID]);

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
			return $afectados;
		}
		public function elimina()
		{

			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';

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
		public function nSec($visible , $orden , $tipo , $valor , $edita , $htmlID)
		{
			global $con;
			
			include_once($_SERVER['DOCUMENT_ROOT'] . '/php/Seccion.php');

			$nSec=new Seccion();

			if(isset($_POST['conID']))
			{
				$nSec->PadreID=$_POST['conID'];
			}
			if($tipo===1)
			{
				$nSec->ModuloID=$valor;
			}
			if($tipo===2)
			{
				$nSec->ContenidoID=$valor;
			}

			$nSec->Prioridad=$orden;
			$nSec->Visible=$visible;
			$nSec->HTMLID=$htmlID;

			if($edita!==false)
			{
				$nSec->updSQL(false,['ID'=>$edita]);
				$nSec->ID=$edita;
			}
			else
			{
				$nSec->insSQL();
			}

			return $nSec->ID;
		}
	}

?>