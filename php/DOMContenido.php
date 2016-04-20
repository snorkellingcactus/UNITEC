<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMModulo.php';

	class DOMContenido extends DOMModulo
	{
		function __construct()
		{
			parent::__construct();

			$this->addToAttribute('class' , 'Contenido');

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
		}
		function load($contID)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMFragment.php';

			$this->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				new DOMFragment
				(
					getTraduccion
					(
						$contID,
						$_SESSION['lang']
					)
				)
			);
		}
	}
?>