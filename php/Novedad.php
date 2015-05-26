<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Novedad extends SQL_Obj
{
	function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct
		(
			$con,
			'Novedades',
			[
				'ID',
				'ImagenID',
				'TituloID',
				'DescripcionID',
				'Fecha',
				'Visible',
				'Prioridad'
			]
		);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
};
?>