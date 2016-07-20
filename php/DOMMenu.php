<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMMenu extends DOMTag
	{
		public $ul;
		public $nav;
		public $span;

		function __construct()
		{
			parent::__construct('div');

			$this->col=['xs'=>12 , 'md'=>2 , 'sm'=>2 , 'lg'=>2];
			$this->addToAttribute('class' , 'menu');

			$this->ul=new DOMTag( 'ul' );
			$this->nav=new DOMTag( 'nav' );

			$this->span=new DOMTag( 'div' );
			$this->span->addToAttribute('class' , 'inset');

			$menu=new DOMTag( 'h1' , gettext( 'Menu' ) );

			$this->nav->appendChild
			(
				$menu->addToAttribute( 'class' , 'hidden-xs' )
			);
			$this->appendChild
			(
				$this->span
			);
		}
		function addOption( $name )
		{
			$this->ul->appendChild
			(
				$name
			);
		}
	}
?>