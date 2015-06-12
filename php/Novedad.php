<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Novedad extends SQL_Obj
{
	function __construct($props=NULL , $con=NULL)
	{
		$nArgs=func_num_args();

		parent::__construct
		(
			'Novedades',
			[
				'ID',
				'ImagenID',
				'TituloID',
				'DescripcionID',
				'Fecha',
				'Visible',
				'Prioridad'
			],
			$con
		);

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
};
?>