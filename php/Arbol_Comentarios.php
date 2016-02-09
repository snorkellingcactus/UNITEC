<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Arbol.php';

	class Arbol_Comentarios extends Arbol
	{
		public $contenidoID;

		function __construct($contenidoID)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ArbolComActions.php';
			//Prevenir la inclusión en vano, haciendo uso inteligente dentro de ArbolActions.
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

			global $con;
			global $vRecID;

			$vRecID=$this->contenidoID=$contenidoID;

			$container=new DOMTag('div');
			$container->classList->add('comentarios');
			$container->col=['xs'=>10 , 'sm'=>10 , 'md'=>10 , 'lg'=>10];

			$formCom=false;
			if(isset($_SESSION['adminID']))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSelBase.php';

				$container->appendChild
				(
					$formCom=new FormCliSelBase('accionesCom')
				);
			}

			parent::__construct
			(
				new ArbolComActions
				(
					$formCom,
					$contenidoID,
					$container
				)
			);


			$this->solveDeps
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT *
							FROM Comentarios
							WHERE Comentarios.RaizID ='.$contenidoID.
						'	ORDER BY Fecha ASC'
					),
					MYSQLI_ASSOC
				),
				'PadreID',
				'ContenidoID',
				$contenidoID
			);
		}

		function render()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliComPub.php';

			return parent::render()->appendChild
			(
				new FormCliComPub($this->contenidoID)
			);
		}
	}
?>