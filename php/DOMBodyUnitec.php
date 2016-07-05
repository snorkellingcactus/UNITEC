<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

	class DOMBodyUnitec extends DOMBody
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeaderUnitec.php';

			$this->setOnLoad( 'JavaScript:inicializa()' )->setAttribute( 'tabindex' , 1 );

			$this->appendChild
			(
				new DOMHeaderUnitec()
			);
		}
	}
?>