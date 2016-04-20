<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class HeadLink  extends DOMTag
	{
		public $rel;
		public $type;
		public $href;

		function __construct()
		{
			parent::__construct('link');

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setHref($args[0]);
			}
		}
		function setRel($rel)
		{
			$this->rel=$rel;

			return $this;
		}
		function setType($type)
		{
			$this->type=$type;

			return $this;
		}
		function setHref($href)
		{
			$this->href=$href;

			return $this;
		}
		function renderChilds(&$tag)
		{

			$this->setAttribute('rel' , $this->rel);
			$this->setAttribute('type' , $this->type);
			$this->setAttribute('href' , $this->href);

			return parent::renderChilds($tag);
		}
	}
?>