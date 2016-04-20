<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

	class DOMGalImg extends DOMTag
	{
		public $link;
		public $p;
		public $span;

		public $titulo;
		public $alt;
		public $url;
		public $src;

		public $actionCheckBox;

		function __construct()
		{
			parent::__construct('div');

			$this->col=['xs'=>12 , 'sm'=>6 , 'md'=>4];

			$this->link=new DOMLink();
			$this->p=new DOMTag('p');
			$this->img=new DOMTag('img');
			$this->span=new DOMTag('span');

			$this->link->setOpensNewWindow(true)->addToAttribute('class' , 'focuseable');

			$this->addToAttribute('class' , 'gImg')->addToAttribute('class' ,'Center-Container');
			$this->img->addToAttribute('class' , 'Absolute-Center');
			$this->span->addToAttribute('class' , 'offscreen');
			$this->p->addToAttribute('class' , 'monoWhite');

			$this->actionCheckBox=false;
		}
		function setSrc($src)
		{
			$this->src=$src;

			return $this;
		}
		function setAlt($alt)
		{
			$this->alt=$alt;

			return $this;
		}
		function setTitulo($titulo)
		{
			$this->titulo=$titulo;

			return $this;
		}
		function setUrl($url)
		{
			$this->url=$url;

			return $this;
		}
		function renderChilds(&$tag)
		{
			if($this->actionCheckBox!==false)
			{
				$this->appendChild
				(
					$this->actionCheckBox
				);
			}
			$this->appendChild
			(
				$this->link->appendChild
				(
					$this->p->setTagValue
					(
						htmlentities
						(
							$this->titulo
						)
					)->appendChild
					(
						$this->span
					)
				)->setUrl
				(
					$this->url
				)->appendChild
				(
					$this->img->setAttribute
					(
						'src',
						htmlentities
						(
							$this->src
						)
					)->setAttribute
					(
						'alt',
						htmlentities
						(
							$this->alt
						)
					)
				)
			);

			return parent::renderChilds($tag);
		}

		public function setActionCheckBox($actionCheckBox)
		{
			$this->actionCheckBox=$actionCheckBox;
		}
	}
?>