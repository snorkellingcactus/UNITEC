<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ModuloBase.php';

	class DOMSeccion extends ModuloBase
	{
		function __construct()
		{
			parent::__construct('section');
		}
		
		function renderChilds(&$doc , &$tag)
		{
			$this->appendChild(new ClearFix());

			return parent::renderChilds($doc , $tag);
		}
	}
?>