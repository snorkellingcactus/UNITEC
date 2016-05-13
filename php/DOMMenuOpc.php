<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

	class DOMMenuOpc extends DOMTag
	{
		public $url;
		public $name;
		public $shortcutChar;
		public $sectionName;
		public $link;
		private $absoluteUrl;

		function __construct($name)
		{
			parent::__construct('li');

			$this->setName
			(
				$name
			)->setShortcutChar
			(
				false
			)->setSectionName
			(
				false
			)->setAbsoluteUrl
			(
				false
			)->appendChild
			(
				$this->link=new DOMLink()
			);
		}
		function setUrl($url)
		{
			$this->url=$url;

			return $this;
		}
		function setAbsoluteUrl($absoluteUrl)
		{
			$this->absoluteUrl=$absoluteUrl;

			return $this;
		}
		function setName($name)
		{
			$this->name=$name;

			return $this;
		}
		function setShortcutChar($char)
		{
			$this->shortcutChar=$char;

			return $this;
		}
		function setSectionName($sectionName)
		{
			$this->sectionName=$sectionName;

			return $this;
		}
		function renderChilds(&$tag)
		{
			if($this->sectionName)
			{
				$urlStr='#'.$this->sectionName;
				
				if( $this->absoluteUrl !== false )
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

					//Revisar . Código en común con VisorImagenes, DOMMenuOpc, Modulo_Novedades , Modulo_Imagenes
					$urlStr=
					'/'								.
					substr( getenv('LANG'), 0 , 2 )	.
					'/espacios/'					.
					getLabName()					.
					'/'								.
					$urlStr;
				}

				$this->setUrl
				(
					$urlStr
				);
			}

			$this->link->setUrl
			(
				$this->url
			)->setName( $this->name );


			if($this->shortcutChar!==false)
			{
				$this->link->setAccessKey
				(
					$this->shortcutChar
				);
			}

			return parent::renderChilds($tag);
		}
	}
?>