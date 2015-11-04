<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQLTagged_Obj.php';

class Evento extends SQLTagged_Obj
{
	function __construct($props=NULL , $con=NULL)
	{
		$nArgs=func_num_args();

		parent::__construct('Eventos',['ID','Tiempo','NombreID','DescripcionID','Visible','Prioridad'] , $con);

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
}

?>