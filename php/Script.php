<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HeadLink.php';

	class Script extends DOMTag
	{
		public $src;

		function __construct()
		{
			parent::__construct('script');

			$this->setAttribute('type' , 'text/javascript');

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setSrc($args[0]);
			}
		}
		function setSrc($src)
		{
			$this->src=$src;

			return $this;
		}
		function renderChilds(&$doc , &$tag)
		{
			$this->setAttribute('src' , $this->src);

			return parent::renderChilds($doc , $tag);		
		}
	}
?>