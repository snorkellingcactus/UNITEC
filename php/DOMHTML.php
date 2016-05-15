<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Script.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/StylesHeet.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Meta.php';

	class DOMHTML extends DOMTag
	{
		public $lang;
		public $meta;
		public $js;
		public $css;
		public $charset;
		public $description;
		public $icon;
		public $sIcon;
		public $title;
		public $toUnset;
		public $toUnsetLen;
		private $head;
		private $body;

		function __construct()
		{
			parent::__construct('html');

			$this->meta=new DOMTagContainer();
			$this->js=new DOMTagContainer();
			$this->css=new DOMTagContainer();

			$this->toUnset=array();
			$this->toUnsetLen=0;

			$this
			->setLang(false)
			->setCharset('utf-8')
			->setIcon(false)
			->setSIcon(false)
			->setDescription(false)
			->setTitle(false)
			->appendChild
			(
				$this->head=new DOMTag('head')
			);

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setLang($args[0]);
			}
		}
		function setBody($body)
		{
			$this->body=$body;
		}
		function getHead()
		{
			return $this->head;
		}
		function addToUnset($toUnset)
		{
			$this->toUnset[$this->toUnsetLen]=$toUnset;

			++$this->toUnsetLen;

			return $this;
		}
		function setLang($lang)
		{
			$this->lang=$lang;

			return $this;
		}
		function setCharset($charset)
		{
			$this->charset=$charset;

			return $this;
		}
		function setDescription($description)
		{
			$this->description=$description;

			return $this;
		}
		function setTitle($title)
		{
			$this->title=$title;

			return $this;
		}
		function setIcon($src)
		{
			$this->icon=$src;

			return $this;
		}
		function setSIcon($src)
		{
			$this->sIcon=$src;

			return $this;
		}
		function head_include($str)
		{
			$pos=strrpos( $str , '.');

			if($pos)
			{
				$tipo=substr($str , $pos+1);

				switch($tipo)
				{
					case 'css':
						return $this->includeCSS($str);
					break;
					case 'js':
						return $this->includeJS($str);
				}
			}
		}
		function includeCSS($src)
		{
			return $this->appendLink
			(
				new StylesHeet($src)
			);
		}
		function includeJS($src)
		{
			return $this->appendScript
			(
				new Script($src)
			);
		}
		function appendMeta($meta)
		{
			$this->meta->appendChild($meta);

			return $this;
		}
		function appendLink($link)
		{
			$this->css->appendChild($link);

			return $this;
		}
		function appendScript($script)
		{
			$this->js->appendChild($script);

			return $this;
		}
		function newMeta()
		{
			return new Meta();
		}
		function newLink($src)
		{
			return new HeadLink($src);
		}
		function renderChilds(&$tag)
		{
			$iLen=$this->toUnsetLen;
			for($i=0;$i<$iLen;++$i)
			{
				//echo '<pre>'.htmlentities('Unsetting $_SESSION["'.$this->toUnset[$i].'"]').'</pre>';

				unset($_SESSION[$this->toUnset[$i]]);
			}

			if($this->lang!==false)
			{
				$this->setAttribute('lang' , $this->lang);
			}

			$this->head->appendChild
			(
				$this->newMeta()->setCharset($this->charset)
			);

			if($this->description!==false)
			{
				$this->head->appendChild
				(
					$this->newMeta()->setName('description')->setContent($this->description)
				);
			}

			$this->head->appendChild
			(
				$this->meta
			);

			if($this->icon!==false)
			{
				$this->head->appendChild
				(
					$this->newLink($this->icon)->setRel('icon')->setType('image/ico')
				);
			}
			if($this->sIcon!==false)
			{
				$this->head->appendChild
				(
					$this->newLink($this->icon)->setRel('shortcut icon')->setType('image/png')
				);
			}

			$this->head->appendChild
			(
				$this->css
			)->appendChild
			(
				$this->js
			);

			if($this->title!==false)
			{
				$this->head->appendChild
				(
					new DOMTag('title' , $this->title)
				);
			}

			return parent::renderChilds($tag);
		}
	}
?>