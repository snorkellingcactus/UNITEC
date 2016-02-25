<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HeadLink.php';

	class Script extends DOMTag
	{
		public $src;
		public $async;
		public $defer;

		function __construct()
		{
			parent::__construct('script');

			$this->setAttribute('type' , 'text/javascript');

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setSrc($args[0]);
			}

			$this->setAsync(false)->setDefer(false);
		}
		function setAsync($async)
		{
			$this->async=$async;

			return $this;
		}
		function setDefer($defer)
		{
			$this->defer=$defer;

			return $this;
		}
		function setSrc($src)
		{
			$this->src=$src;

			return $this;
		}
		function renderChilds(&$doc , &$tag)
		{
			$this->setAttribute('src' , $this->src);

			if($this->async!==false)
			{
				$this->setAttribute('async' , 'async');
			}
			if($this->defer!==false)
			{
				$this->setAttribute('defer' , 'defer');
			}

			return parent::renderChilds($doc , $tag);		
		}
	}
?>