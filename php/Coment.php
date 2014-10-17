<?php
require_once 'SQL_Obj.php';
class Coment extends SQL_Obj
{

	function __construct($con)
	{
		$nArgs=func_num_args();
		
		parent::__construct
		(
			$con,
			'Comentarios',
			[
				'GrupoID',
				'IP',
				'Usuario',
				'Contenido',
				'Baneado'
			]
		);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}
?>