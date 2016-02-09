<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabBase.php';

	class DOMLabLi extends DOMLabBase
	{
		public $div;
		public $titulo;
		public $link;
		public $name;
		public $target;

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
		function setTarget($target)
		{
			$this->target=$target;

			return $this;
		}
		function setLink($link)
		{
			$this->link=$link;

			return $this;
		}
		function renderChilds(&$tag , &$doc)
		{
			if(!empty($this->link))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

				$a=new DOMLink();

				$a->classList->add('focuseable');

				if(!empty($this->target))
				{
					$a->setAttribute('target' , $this->target);
				}

				$this->titulo->appendChild
				(
					$a->setName($this->name)->setUrl($this->link)
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