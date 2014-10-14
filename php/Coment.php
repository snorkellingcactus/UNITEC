<?php
class Coment extends SQLObj
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