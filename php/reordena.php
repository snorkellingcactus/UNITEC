<?php
	function getPriorizados($coleccion)
	{
		global $con;

		$i=0;
		$j=0;
		$priorizados=array();
		$prioridades=array();

		while(isset($coleccion[$i]))
		{
			$prioridad=fetch_all
			(
				$con->query
				(
					'	SELECT Prioridad , ID
						FROM Prioridades
						WHERE GrupoID='.$coleccion[$i]['PrioridadesGrpID'].'
						AND LabID='.$_SESSION['lab'].'
						LIMIT 1
					'
				),
				MYSQLI_NUM
			);
			
			if(isset($prioridad[0][0]))
			{
				$prior=$prioridad[0][0];

				$coleccion[$i]['PrioridadID']=$prioridad[0][1];
				$coleccion[$i]['Prioridad']=$prior;

				if(isset($priorizados[$prior]))
				{
					$priorizado=& $priorizados[$prior];

					if(isset($priorizado[1]))
					{
						$priorizado[count($priorizado)]=$coleccion[$i];
					}
					else
					{
						$priorizado=[$priorizado , $coleccion[$i]];
					}
				}
				else
				{
					$prioridades[$j]=$prior;
					$priorizados[$prior]=$coleccion[$i];
				}

				++$j;
			}

			++$i;
		}
		$coleccion=array();

		$k=0;
		$i=0;

		sort($prioridades);

		while(isset($prioridades[$k]))
		{
			$prioridad=$prioridades[$k];

			$obj=$priorizados[$prioridad];

			if(isset($obj[0]))
			{
				$j=0;
				while(isset($obj[$j]))
				{
					$coleccion[$i]=$obj[$j];
					++$j;
					++$i;
				}
			}
			else
			{
				$coleccion[$i]=$obj;
				++$i;
			}

			++$k;
		}


		return $coleccion;
	}
	function reordena($lugar , $sqlObj , $condicion , $discProp, $valProp ,$edita)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		$coleccion=fetch_all
		(
			$con->query
			(
				'	SELECT '.$sqlObj->table.'.'.$discProp.', '.$sqlObj->table.'.PrioridadesGrpID
					FROM '.$sqlObj->table.' 
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID='.$sqlObj->table.'.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE '.$condicion.'
					AND TagsTarget.TagID=Laboratorios.TagID
				'
			)
			,
			MYSQLI_ASSOC
		);
/*
		echo '<pre>Consulta Coleccion:';
		print_r
		(
			'	SELECT '.$discProp.', PrioridadesGrpID
				FROM '.$sqlObj->table.'
				LEFT OUTER JOIN TagsTarget
				ON TagsTarget.GrupoID='.$sqlObj->table.'.TagsGrpID
				LEFT OUTER JOIN Laboratorios
				ON Laboratorios.ID='.$_SESSION['lab'].'
				WHERE '.$condicion.'
				AND TagsTarget.TagID=Laboratorios.TagID
			'
		);
		echo '</pre>';
*/
		$coleccion=getPriorizados($coleccion);

/*
		echo '<pre>Colección:';
		print_r($coleccion);
		echo '</pre>';

		echo '<pre>Lugar:';
		print_r($lugar);
		echo '</pre>';
*/
		$seleccionado=0;
		while(isset($coleccion[$seleccionado]) && $coleccion[$seleccionado][$discProp]!=$lugar)
		{
			++$seleccionado;
		}
		
		if(!isset($coleccion[0]))
		{
			//echo '<pre>Reordena: El número'.$seleccionado;echo ' no existe</pre>';
			return 0;
		}

		if($edita)
		{
			$actual=0;
			//echo '<pre>$discProp( '.$coleccion[$actual][$discProp].' ) == $valProp( '.$valProp.' )</pre>';
			while(isset($coleccion[$actual]) && $coleccion[$actual][$discProp]!=$valProp)
			{
				//echo '<pre>$discProp( '.$coleccion[$actual][$discProp].' ) == $valProp( '.$valProp.' )</pre>';
				++$actual;
			}
/*
			echo '<pre>Actual: '.$actual;
			echo '</pre>';
*/
			//La lista de valores posibles en el select comprende
			//todas las secciones EXEPTO la que está siendo editada,
			//lo que hace necesario convertir los índices ya que
			//$coleccion comprende TODAS las secciones.
			if($seleccionado>$actual)
			{
				--$seleccionado;
			}
/*
			echo '<pre>Seleccionado: '.$seleccionado;
			echo '</pre>';
*/
			$desde=$actual;
			$hasta=$seleccionado;

			if($actual==$seleccionado)
			{
				return $coleccion[$actual]['Prioridad'];
			}
		}
		else
		{
			$hasta=count($coleccion)-1;

			//Si es el último, retorno el máximo.
			if($lugar[0]==='b')
			{
				return intVal($coleccion[$hasta]['Prioridad'])+1;
			}
			else
			{
				$desde=$seleccionado;
			}
		}

		if($hasta>$desde)
		{
			$j=$desde;
			$jMax=$hasta+1;
			$inc=1;
			
			if($edita)
			{
				$inc=-1;
				$j=$j+1;
			}
		}
		else
		{
			$j=$hasta;
			$jMax=$desde+1;
			$inc=1;
		}
/*
		echo '<pre>Reordena: Se cambiará del número '.$j.' Al '.$jMax.' con '.$inc;
		echo '</pre>';
*/
		//Hago un lugar para la nueva seccion desplazando sus siguientes una
		//posición más.
		while($j<$jMax)
		{
/*
			echo '<pre>';
			print_r
			(
				'	UPDATE Prioridades
					SET Prioridad='.
				(
					intVal
					(
						$coleccion[$j]['Prioridad']
					)+$inc
				).
				'	WHERE ID='.$coleccion[$j]['PrioridadID']
			);
			echo '</pre>';
*/
			$con->query
			(
				'	UPDATE Prioridades
					SET Prioridad='.
				(
					intVal
					(
						$coleccion[$j]['Prioridad']
					)+$inc
				).
				'	WHERE ID='.$coleccion[$j]['PrioridadID']
			);

			++$j;
		}
		return $coleccion[$seleccionado]['Prioridad'];
	}
?>