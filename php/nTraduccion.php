<?
	//Crea un nuevo contenido con una traducción para ese contenido.
	function nTraduccion($contenido , $lenguaje)
	{
		global $con, $raiz;
		echo '<pre>'.$raiz.'</pre>';

		include_once $raiz.'php/Contenido.php';
		include_once $raiz.'php/Traduccion.php';
		include_once $raiz.'php/Foraneas.php';

		$traduccion=new Traduccion
		(
			$con,
			[
				'Texto'=>htmlentities($contenido),
				'LenguajeID'=>$lenguaje
			]
		);
		$traduccion->insForaneas
		(
			new Contenido($con),
			[
				'ContenidoID'=>'ID'
			]
		);

		return $traduccion;
	}
?>