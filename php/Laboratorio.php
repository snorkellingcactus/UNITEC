<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQLTagged_Obj.php';

	class Laboratorio extends SQLTagged_Obj
	{
		function __construct($props=NULL , $con=NULL)
		{
			$nArgs=func_num_args();

			parent::__construct
			(
				'Laboratorios',
				[
					'ID',
					'Latitud',
					'Longitud',
					'DireccionID',
					'Mail',
					'Telefono',
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