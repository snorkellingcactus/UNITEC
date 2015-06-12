<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Traduccion extends SQL_Obj
{
	public function __construct($props=null , $con=NULL)
	{
		$nArgs=func_num_args();

		parent::__construct('Traducciones',['ID','ContenidoID','LenguajeID','Texto'] , $con);

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
}

?>