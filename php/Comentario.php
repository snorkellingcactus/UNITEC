<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Obj.php';

	class Comentario extends SQL_Obj
	{
		function __construct($props=NULL , $con=NULL)
		{
			$nArgs=func_num_args();
			
			parent::__construct
			(
				'Comentarios',
				[
					'ID',
					'ContenidoID',
					'RaizID',
					'PadreID',
					'Fecha',
					'Baneado',
					'Nombre'
				],
				$con
			);

			$this->Nombre='Anónimo';

			if($props!==NULL)
			{
				$this->getAsoc($props);
			}
		}
	}
?>