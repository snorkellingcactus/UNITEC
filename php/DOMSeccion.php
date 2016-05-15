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
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/OffText.php';

			$this->appendChild
			(
				new ClearFix()
			);
/*
			->appendChild
			(
				new OffText
				(
					'h1',
					rawurldecode
					(
						$this->htmlID
					)
				)
			);
*/



			return parent::renderChilds($tag);
		}
	}
?>