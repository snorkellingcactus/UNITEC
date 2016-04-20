<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMModuloBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class DOMSeccion extends DOMModuloBase
	{
		function __construct()
		{
			parent::__construct('section');
		}
		
		function renderChilds(&$tag)
		{
			$this->appendChild(new ClearFix());

			return parent::renderChilds($tag);
		}
	}
?>