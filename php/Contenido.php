<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Contenido extends SQL_Obj
{
	public function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct($con, 'Contenidos' , ['ID']);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

?>