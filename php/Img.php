<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Img extends SQL_Obj
{
	function __construct($con)
	{
		$nArgs=func_num_args();
		
		parent::__construct
		(
			$con,
			'Imagenes',
			[
				'ID',
				'Url',
				'Alt',
				'TituloID',
				'LenguajeID',
				'Visible',
				'Prioridad'
			]
		);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}
?>