<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMail.php';

	class FooterMail extends FooterContainer
	{
		function __construct()
		{
			parent::__construct();

			$this->appendChild
			(
				$titulo=new DOMTag
				(
					'h1',
					gettext( 'Escribinos' )
				)
			);

			$titulo->col=[ 'xs'=> 12 , 'sm'=> 12 , 'md'=> 12 , 'lg'=> 12];

			$this->appendChild
			(
				new FormCliMail()
			);
		}
	}
?>