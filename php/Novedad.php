<?php
include_once('SQL_Obj.php');

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
				'Imagen',
				'Titulo',
				'Descripcion',
				'Fecha',
				'Comentarios'
			]
		);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
};
?>