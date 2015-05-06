<?php
require_once('SQL_Obj.php');

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