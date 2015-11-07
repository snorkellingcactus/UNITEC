<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQLTagged_Obj.php';

	class Seccion extends SQLTagged_Obj
	{
		function __construct($props=NULL , $con=NULL)
		{
			$nArgs=func_num_args();

			parent::__construct
			(
				'Laboratorios',
				[
					'ID',
					'Ubicacion',
					'Direccion',
					'Mail',
					'Facebook',
					'Twitter',
					'NombreID',
					'TagID',
					'Organigrama',
					'Enlace',
					'Color',
					'PadreID'
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