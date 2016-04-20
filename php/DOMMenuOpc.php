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
				$this->setUrl('#'.$this->sectionName);
			}

			$this->link->setUrl
			(
				$this->url
			)->setName($this->name);


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