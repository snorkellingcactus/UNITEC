<?php
	function getTraduccion($contenidoID , $lenguajeID , $limite=false)
	{
		global $con;
/*
		echo '<pre>';
		print_r
		(
			'	SELECT Texto,
				CASE LenguajeID
				WHEN '.$lenguajeID.' THEN 0
				ELSE 1
				END AS Ord
				FROM Traducciones
				WHERE ContenidoID='.$contenidoID.'
				ORDER BY Ord
				LIMIT 1
			'
		);
		echo '</pre>';
*/
		return html_entity_decode
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Texto,
						CASE LenguajeID
						WHEN '.$lenguajeID.' THEN 0
						ELSE 1
						END AS Ord
						FROM Traducciones
						WHERE ContenidoID='.$contenidoID.'
						ORDER BY Ord
						LIMIT 1
					'
				),
				MYSQLI_NUM
			)[0][0]
		);
	}
?>