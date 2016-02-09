<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

	class FooterInfoBase extends DOMTagContainer
	{
		public $link;
		public $text;

		function __construct($imgSrc , $imgAlt)
		{
			parent::__construct();

			$img=new DOMTag('img');
			$img->classList->add('circulo');
			
			$this->appendChild
			(
				$img->setAttribute('src' , $imgSrc)->setAttribute('alt' , $imgAlt)
			)->appendChild
			(
				$this->text=new DOMTag('i')
			)->setLink(false);

			$this->text->classList->add('gris');
		}

		function setLink($link)
		{
			$this->link=$link;
		}

		function renderChilds(&$doc , &$tag)
		{
			if($this->link!==false)
			{
				$this->text->appendChild($this->link);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>