<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Obj.php';

class Evento extends SQL_Obj
{
	function __construct($props=NULL , $con=NULL)
	{
		$nArgs=func_num_args();

		parent::__construct('Eventos',['ID','Tiempo','Nombre','DescripcionID','Visible','Prioridad'] , $con);

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
}

?>