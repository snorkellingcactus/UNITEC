<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

	class DOMBodyUnitec extends DOMBody
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHeaderUnitec.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

			$this->setOnLoad( 'JavaScript:inicializa()' )->setAttribute( 'tabindex' , 1 );

			$this->appendChild
			(
				new DOMHeaderUnitec()
			)->appendChild
			(
				( new DOMLink() )
				->setName( gettext( 'Saltar a la navegación' ) )
				->setUrl( '#navigation' )
				->setAccessKey( 'N' )
				->setAttribute( 'tabindex' , 3 )
				->setAttribute( 'id' , 'skip-to-navigation' )
				->setCol( [ 'xs' => 12 , 'sm' => 10 , 'md' => 10 , 'lg' => 10 ] )
			);
		}
	}
?>