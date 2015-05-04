<?php
require_once 'SQL_Obj.php';

class Contenido extends SQL_Obj
{
	public function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct($con, 'Contenido',['Contenido','Fecha','Lenguaje']);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

?>