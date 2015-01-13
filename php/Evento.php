<?php
require_once 'SQL_Obj.php';

class Evento extends SQL_Obj
{
	public function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct($con, 'Eventos',['Tiempo','Nombre','Descripcion']);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

?>