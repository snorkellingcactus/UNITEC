<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Obj.php';

	class Seccion extends SQL_Obj
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
					'Prioridad',
					'ModuloID',
					'ContenidoID',
					'PadreID',
					'HTMLID'
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