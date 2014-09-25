<?php

class Img extends SQLObj
{
	function __construct($con)
	{
		$nArgs=func_num_args();
		
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
		
		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}
?>