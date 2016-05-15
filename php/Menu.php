<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQLTagged_Obj.php';

	class Menu extends SQLTagged_Obj
	{
		function __construct($props=NULL , $con=NULL)
		{
			$nArgs=func_num_args();

			parent::__construct
			(
				'Menu',
				[
					'ID',
					'ContenidoID',
					'SeccionID',
					'UrlID',
					'Atajo',
					'PrioridadesGrpID',
					'Visible',
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