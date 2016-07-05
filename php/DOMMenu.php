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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/OffText.php';

			$this->col=['xs'=>12 , 'md'=>2 , 'sm'=>2 , 'lg'=>2];
			$this->addToAttribute('class' , 'menu');

			$this->ul=new DOMTag( 'ul' );
			$this->nav=new DOMTag( 'nav' );

			$this->span=new DOMTag( 'div' );
			$this->span->addToAttribute('class' , 'inset');

			$this->appendChild
			(
				new OffText( 'h1' , gettext( 'Menu Principal' ) )
			)->appendChild
			(
				$this->span->appendChild
				(
					$this->nav->appendChild($this->ul)
				)
			);
		}
		function addOption($name)
		{
			$this->ul->appendChild
			(
				$name
			);
		}
		function renderChilds( &$tag )
		{
			return parent::renderChilds($tag);
		}
	}
?>