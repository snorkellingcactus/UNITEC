<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Evento extends SQL_Obj
{
	public function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct($con, 'Eventos',['ID','Tiempo','Nombre','DescripcionID','Visible','Prioridad']);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

?>