<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQLTagged_Obj.php';

	class Seccion extends SQLTagged_Obj
	{
		function __construct($props=NULL , $con=NULL)
		{
			$nArgs=func_num_args();

			parent::__construct
			(
				'Secciones',
				[
					'ID',
					'Visible',
					'PrioridadesGrpID',
					'ModuloID',
					'ContenidoID',
					'PadreID',
					'TituloID',
					'AtajoID',
					'OpcSetID',
					'TagsGrpID'
				],
				$con
			);

			if($props!==NULL)
			{
				$this->getAsoc($props);
			}
		}
	};
?>