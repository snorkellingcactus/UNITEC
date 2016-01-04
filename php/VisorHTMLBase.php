<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Visor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

	class VisorHTMLBase extends Visor
	{
		public $html;
		public $titulo;
		public $img;
		public $thumbPathA;
		public $thumbPathB;
		public $thumbExt;
		public $lName;

		function __construct()
		{
			parent::__construct();

			$this->html=new DOMTagContainer();
			$this->img=new DOMTag('img');

			$this->lName=$lName=getLabName();
			$this->thumbPathA='/img/miniaturas/visor/';
			$this->thumbPathB='/img/miniaturas/galeria/';

			$this->thumbExt='.png';

		}
		public function formatUrlFile($id)
		{
			return $id.$this->thumbExt;
		}
		public function formatUrlA($id)
		{
			return $this->thumbPathA.$this->formatUrlFile($id);
		}
		public function formatUrlB($id)
		{
			return $this->thumbPathB.$this->formatUrlFile($id);
		}
		public function getContent()
		{
			parent::getContent();

			return $this->html->getHTML();
		}
		public function setImgAlt($alt)
		{
			$this->img->setAttribute('alt' , $alt);

			return $this;
		}
		public function setImgSrc($src)
		{
			$this->img->setAttribute('src' , $src);

			return $this;
		}
		public function setTitulo($titulo)
		{
			$this->titulo->setTagValue($titulo);

			return $this;
		}
	}
?>