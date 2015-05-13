<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Obj.php';

class Traduccion extends SQL_Obj
{
	public function __construct($con)
	{
		$nArgs=func_num_args();

		parent::__construct($con, 'Traducciones',['ID','ContenidoID','LenguajeID','Texto']);

		if($nArgs>1)
		{
			$this->getAsoc(func_get_args()[1]);
		}
	}
}

?>