<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMMenu extends DOMTag
	{
		public $ul;
		public $nav;

		function __construct()
		{
			parent::__construct('div');

			$this->col=['xs'=>12 , 'md'=>2 , 'sm'=>2 , 'lg'=>2];
			$this->classList->add('menu');

			$this->ul=new DOMTag('ul');
			$this->nav=new DOMTag('nav');

			$this->appendChild
			(
				$this->nav->appendChild($this->ul)
			);
		}
		function addOption($name)
		{

			$this->ul->appendChild
			(
				$name
			);
		}
		function renderChilds(&$doc , &$tag)
		{
			return parent::renderChilds($doc , $tag);
		}
	}
?>