<?php
	function reordena($lugar , $sqlObj , $condicion , $discProp, $valProp ,$edita)
	{
		$prefijo=$lugar[0];
		$pOrden=intVal(substr($lugar , 1));

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		/*
			echo '<pre>';
			print_r
			(
				'	SELECT '.$discProp.', Prioridad
					FROM '.$sqlObj->table.' 
					WHERE '.$condicion.' 
					ORDER BY Prioridad ASC'
			);
			echo '</pre>';
		*/
		$coleccion=fetch_all
		(
			$con->query
			(
				'	SELECT '.$discProp.', Prioridad
					FROM '.$sqlObj->table.' 
					WHERE '.$condicion.' 
					ORDER BY Prioridad ASC'
			)
			,
			MYSQLI_ASSOC
		);
/*
		$cMax=count($coleccion);
		if($prefijo=='b' || $pOrden===0)
		{
			$ultimo=$coleccion[$cMax-1];
			$primero=$coleccion[0];

			if($pOrden===0)
			{
				$ultimo=$coleccion[0];
				$primero=$coleccion[$cMax-1];
			}

			$nOrden=$ultimo['Prioridad'];

			echo '<pre>';
			print_r
			(
				'	UPDATE '.$sqlObj->table.'
					SET Prioridad='.$primero['Prioridad'].'
					WHERE '.$discProp.'='.$ultimo[$discProp]
			);
			echo '</pre>';

			$con->query
			(
				'	UPDATE '.$sqlObj->table.'
					SET Prioridad='.$primero['Prioridad'].'
					WHERE '.$discProp.'='.$ultimo[$discProp]
			);
			echo '<pre>nOrden:'.$nOrden.'</pre>';
			return $nOrden;
		}
*/
		//Si alguna seccion ocupa el lugar de la nueva la muevo a ella y
		//en el caso de que sea necesario a sus siguientes.
//		echo '<pre>Edita:';var_dump($edita);echo '</pre>';
		$desde=count($coleccion)-1;
		if($desde<0)
		{
			return 0;
		}

		if($edita)
		{
			$desde=0;
			while($coleccion[$desde][$discProp]!==$valProp && $desde<30)
			{
				++$desde;
			}
		}
		else
		{
			++$desde;
		}
	
//			$j=min($desde, $pOrden);
//			$sMax=max($desde , $pOrden);

		if($prefijo==='b')
		{
			$pOrden=count($coleccion)-1;
			if(!$edita)
			{
				$pOrden++;
			}
		}
		$inc=1;
		$j=$pOrden;
		$sMax=$desde;

		if($desde<$pOrden)
		{

//			echo '<pre>Al reves';echo '</pre>';

			$inc=-1;

			$j=$desde+1;
			$sMax=$pOrden+1;
		}

//		echo '<pre>Desde:'.$desde.'</pre>';
//		echo '<pre>Hasta:'.$pOrden.'</pre>';
		if($pOrden===count($coleccion))
		{
//			echo '<pre>';print_r($j.' < '.$sMax);echo '</pre>';

			return $coleccion[$pOrden-1]['Prioridad'];
		}

		$inicial=floatVal($coleccion[$j]['Prioridad']);
		
//		echo '<pre>';print_r($j.' < '.$sMax);echo '</pre>';

		while($j<$sMax)
		{
			$nID=$coleccion[$j][$discProp];

			$consulta='update '.$sqlObj->table.' set Prioridad='.(intVal($coleccion[$j]['Prioridad'])+$inc).' where '.$discProp.'='.$nID;
//			echo '<pre>';print_r($consulta);echo '</pre>';

			$con->query($consulta);

			++$j;

			if($j>20)
			{
				die('fail');
			}
		}
		$nOrden=intVal($coleccion[$pOrden]['Prioridad']);
//		echo '<pre>nOrden:'.$nOrden.'</pre>';
		return $nOrden;
	}
?>