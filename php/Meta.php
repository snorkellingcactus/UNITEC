<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class Meta extends DOMTag
	{
		public $charset;
		public $http_equiv;
		public $content;
		public $name;

		function __construct()
		{
			parent::__construct('meta');

			$this->setContent(false)->setName(false)->setHttpEquiv(false)->setCharset(false);
		}
		function setCharset($charset)
		{
			$this->charset=$charset;

			return $this;
		}
		function setHttpEquiv($http_equiv)
		{
			$this->http_equiv=$http_equiv;
			
			return $this;
		}
		function setContent($content)
		{
			$this->content=$content;
			
			return $this;
		}
		function setName($name)
		{
			$this->name=$name;
			
			return $this;
		}
		function renderChilds(&$tag)
		{
			if($this->name!==false)
			{
				$this->setAttribute('name' , $this->name);
			}
			if($this->charset!==false)
			{
				$this->setAttribute('charset' , $this->charset);
			}
			if($this->http_equiv!==false)
			{
				$this->setAttribute('http-equiv' , $this->http_equiv);
			}
			if($this->content!==false)
			{
				$this->setAttribute('content' , $this->content);
			}

			return parent::renderChilds($tag);
		}
	}
?>