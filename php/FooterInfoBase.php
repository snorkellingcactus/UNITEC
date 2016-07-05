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
			$img->addToAttribute('class' , 'circulo');
			
			$this->appendChild
			(
				$img->setAttribute('src' , $imgSrc)->setAttribute('alt' , $imgAlt)
			)->appendChild
			(
				$this->text=new DOMTag('span')
			)->setLink(false);

			$this->text->addToAttribute('class' , 'gris');
		}

		function setLink($link)
		{
			$this->link=$link;
		}

		function renderChilds(&$tag)
		{
			if($this->link!==false)
			{
				$this->text->appendChild($this->link);
			}

			return parent::renderChilds($tag);
		}
	}
?>