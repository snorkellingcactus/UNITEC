<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabBase.php';

	class DOMLabLi extends DOMLabBase
	{
		public $div;
		public $titulo;
		public $link;
		public $name;

		function __construct($name , $color)
		{
			parent::__construct('li');

			$this->name=$name;

			$this->div=new DOMTag('div');
			$this->titulo=new DOMTag('h1');

			$this->div->classList->add('organicaja')->add($color);

			$this->appendChild
			(
				$this->div->appendChild($this->titulo)
			);
		}
		function setLink($link)
		{
			$this->link=$link;
		}
		function renderChilds(&$tag , &$doc)
		{
			if(!empty($this->link))
			{
				$a=new DOMTag('a' , $this->name);

				$this->titulo->appendChild
				(
					$a->setAttribute('href' , '/espacios/'.addslashes($this->link))
				);
			}
			else
			{
				$this->titulo->setTagValue($this->name);
			}

			return parent::renderChilds($tag , $doc);
		}
	}
?>