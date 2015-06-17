<?php
	function reordena($lugar , $sqlObj , $condicion , $omite)
	{
		$lugar=$_POST['Lugar'];
		$prefijo=$lugar[0];
		$pOrden=intVal(substr($lugar , 1));

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		if($prefijo=='b')
		{
			echo '<pre>';
			print_r('select max(Prioridad) from '.$sqlObj->table.' WHERE'.$condicion);
			echo '</pre>';
			//El último + 1.
			$nOrden=fetch_all($con->query('select max(Prioridad) from '.$sqlObj->table.' WHERE'.$condicion) , MYSQLI_NUM)[0][0]+1;
		}
		else
		{
			$coleccion=$con->query('SELECT * FROM Secciones WHERE '.$condicion.' ORDER BY Prioridad ASC');
			$coleccion=fetch_all($coleccion , MYSQLI_ASSOC);
			//Si alguna seccion ocupa el lugar de la nueva la muevo a ella y
			//en el caso de que sea necesario a sus siguientes.

			$j=$pOrden;
			$nOrden=intVal($coleccion[$pOrden]['Prioridad']);
			$sMax=count($coleccion);

			while($j<$sMax && $coleccion[$j]['Prioridad']==($nOrden+$j-$pOrden))
			{

				if($omite && $coleccion[$j]['ID']===$_SESSION['conID'])
				{
					$j++;
					continue;
				}
				$nID=$coleccion[$j]['ID'];

				$consulta='update '.$sqlObj->table.' set Prioridad='.(intVal($coleccion[$j]['Prioridad'])+1).' where ID='.$nID;

				$con->query($consulta);

				++$j;

				if($j>20)
				{
					die('fail');
				}
			}
		}

		return $nOrden;
	}
?>