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

			$this->link->setOpensNewWindow(true)->classList->add('focuseable');

			$this->classList->add('gImg')->add('Center-Container');
			$this->img->classList->add('Absolute-Center');
			$this->span->classList->add('offscreen');
			$this->p->classList->add('monoWhite');

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
		function renderChilds(&$doc , &$tag)
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

			return parent::renderChilds($doc , $tag);
		}

		public function setActionCheckBox($actionCheckBox)
		{
			$this->actionCheckBox=$actionCheckBox;
		}
	}
?>