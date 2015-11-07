<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabBase.php';

	class DOMLabLi extends DOMLabBase
	{
		public $div;
		public $titulo;

		function __construct($name , $color)
		{
			parent::__construct('li');

			$this->div=new DOMTag('div');
			$this->titulo=new DOMTag('h1' , $name);

			$this->div->classList->add('organicaja')->add($color);

			$this->appendChild
			(
				$this->div->appendChild($this->titulo)
			);
		}
	}
?>