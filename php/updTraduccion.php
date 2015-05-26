<?php
function updTraduccion($texto , $conID , $lang)
{
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

	global $con;

	$traduccion=$con->query
	(
		'	SELECT ID
			FROM Traducciones
			WHERE ContenidoID='.$conID.	
		'	AND LenguajeID='.$lang
	);
	echo '<pre>'.'	SELECT ID
			FROM Traducciones
			WHERE ContenidoID='.$conID.	
		'	AND LenguajeID='.$lang.'</pre>';
	if($traduccion->num_rows)
	{
		echo '<pre>Existe una traduccion para este idioma, se actualizará</pre>';

		$traduccion=fetch_all($traduccion , MYSQLI_NUM);

		$con->query
		(
			'	UPDATE Traducciones
				SET Texto="'.$texto.'"
				WHERE ID='.$traduccion[0][0]
		);

		echo '<pre>'.'	UPDATE Traducciones
				SET Texto="'.$texto.'"
				WHERE ID='.$traduccion[0][0].'</pre>';
	}
	else
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';

		$traduccion=new Traduccion
		(
			$con,
			[
				'ContenidoID'=>$conID,
				'LenguajeID'=>$lang,
				'Texto'=>$texto
			]
		);
		$traduccion->insSQL();
	}
}
function updTraducciones($textos , $conID , $lang , $sMax=false)
{
	if(session_status()===PHP_SESSION_NONE)
	{
		session_start();
	}

	$sMax=$sMax || count($conID);

	for($s=0;$s<$sMax;$s++)
	{
		updTraduccion($textos[$s] , $conID[$s] , $lang);
	}
}
?>