<?
	//Crea un nuevo contenido con una traducción para ese contenido.
	function nTraduccion($contenido , $lenguaje)
	{
		global $con, $raiz;

		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Contenido.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Traduccion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';

		$traduccion=new Traduccion
		(
			[
				'Texto'=>htmlentities($contenido),
				'LenguajeID'=>$lenguaje
			]
		);
		$traduccion->insForanea
		(
			new Contenido(),
			'ContenidoID',
			'ID'
		);

		return $traduccion;
	}
?>