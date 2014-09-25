<?php

class Img extends SQLObj
{
	function __construct($con)
	{

		parent::__construct
		(
			$con,
			'Imagenes',
			[
				'Url',
				'Contenido',
				'Ancho',
				'Alto',
				'Alt',
				'Titulo',
				'Comentarios',
				'Lenguaje'
			]
		);
	}
}

?>