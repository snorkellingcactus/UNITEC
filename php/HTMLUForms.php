<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLUnitecBase.php';

	class HTMLUForms extends DOMHTMLUnitecBase
	{
		function __construct()
		{
			parent::__construct();

			$this->head_include
			(
				'/seccs/visor.css'
			)->head_include
			(
				'/forms/forms.css'
			)->head_include
			(
				'/js/head.js'
			)->head_include
			(
				'/ckeditor/ckeditor.js'
			)->head_include
			(
				'/js/loadEditor.js'
			);
		}
	}

?>

