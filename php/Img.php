<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQLTagged_Obj.php';

class Img extends SQLTagged_Obj
{
	function __construct($props=NULL , $con=NULL)
	{
		$nArgs=func_num_args();
		
		parent::__construct
		(
			'Imagenes',
			[
				'ID',
				'Url',
				'AltID',
				'TituloID',
				'LenguajeID',
				'Fecha',
				'Visible',
				'Prioridad'
			],
			$con
		);

		if($props!==NULL)
		{
			$this->getAsoc($props);
		}
	}
}
?>