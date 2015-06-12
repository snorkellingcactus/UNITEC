<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Obj.php';

class Contenido extends SQL_Obj
{
	function __construct($props=NULL , $con=NULL)
	{
		$nArgs=func_num_args();

		parent::__construct('Contenidos' , ['ID']);

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
}

?>