<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	
	class DOMTCell extends DOMTag
	{
		public $colspan;

		function __construct($tag)
		{
			parent::__construct($tag);

			$this->setColspan(false);
		}
		function setColspan($colspan)
		{
			$this->colspan=$colspan;

			return $this;
		}
		function renderChilds(&$tag)
		{
			if($this->colspan!==false)
			{
				$this->setAttribute('colspan' , $this->colspan);
			}

			return parent::renderChilds($tag);
		}
	}
?>