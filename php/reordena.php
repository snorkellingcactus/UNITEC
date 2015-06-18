<?php
	function reordena($lugar , $sqlObj , $condicion , $discProp, $valProp ,$edita)
	{
		$prefijo=$lugar[0];
		$pOrden=intVal(substr($lugar , 1));

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;

		if($prefijo=='b')
		{
			/*
			echo '<pre>';
			print_r
			(
				'	SELECT IFNULL(max(Prioridad), 0) AS max
				FROM '.$sqlObj->table.' 
				WHERE '.$condicion
			);
			echo '</pre>';
			*/
			//El último + 1.
			$nOrden=intVal
			(
				intVal
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT IFNULL(max(Prioridad), 0) AS max
								FROM '.$sqlObj->table.' 
								WHERE '.$condicion
						),
						MYSQLI_NUM
					)[0][0]
				)+1
			);
		}
		else
		{
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
			//Si alguna seccion ocupa el lugar de la nueva la muevo a ella y
			//en el caso de que sea necesario a sus siguientes.

			$j=$pOrden;
			$nOrden=floatVal($coleccion[$pOrden]['Prioridad']);
			$sMax=count($coleccion);
			
			if($edita)
			{
/*
				echo '<pre>Prioridad actual:';
				print_r
				(
					'	SELECT Prioridad
							FROM '.$sqlObj->table.'
							WHERE '.$discProp.'='.$valProp
				);
				echo '</pre>';
				$val=fetch_all
				(
					$con->query
					(
						'	SELECT Prioridad
							FROM '.$sqlObj->table.'
							WHERE '.$discProp.'='.$valProp
					),
					MYSQLI_NUM
				)[0][0];
				echo '<pre>Valor:';
				print_r($val);
				echo '</pre>';

				echo '<pre>Consulta:';
				print_r
				(
					'	UPDATE '.$sqlObj->table.'
						SET Prioridad='.$val.'
						WHERE '.$discProp.'='.$coleccion[$pOrden][$discProp]
				);
				echo '</pre>';
*/
				$con->query
				(
					'	UPDATE '.$sqlObj->table.'
						SET Prioridad='.fetch_all
						(
							$con->query
							(
								'	SELECT Prioridad
									FROM '.$sqlObj->table.'
									WHERE '.$discProp.'='.$valProp
							),
							MYSQLI_NUM
						)[0][0].'
						WHERE '.$discProp.'='.$coleccion[$pOrden][$discProp]
				);
			}
			else
			{
			/*
				echo '<pre>';
				print_r
				(
					$j.' < '.$sMax .' && '. $coleccion[$j]['Prioridad'].' == '.($nOrden+$j-$pOrden)
				);
				echo '</pre>';
			*/


				while($j<$sMax && $coleccion[$j]['Prioridad']==($nOrden+$j-$pOrden))
				{
					$nID=$coleccion[$j][$discProp];

					$consulta='update '.$sqlObj->table.' set Prioridad='.(intVal($coleccion[$j]['Prioridad'])+1).' where '.$discProp.'='.$nID;
					echo '<pre>';
					print_r($consulta);
					echo '</pre>';

					$con->query($consulta);

					++$j;

					if($j>20)
					{
						die('fail');
					}
				}
			}

			
		}
		echo '<pre>nOrden:'.$nOrden.'</pre>';
		return $nOrden;
	}
?>