<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Obj.php';

	class Menu extends SQL_Obj
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
					'Url',
					'Prioridad',
					'Visible'
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