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

			include $_SERVER['DOCUMENT_ROOT'] . '/php/FormSrvBuilder.php';

			$formHandler=new FormSrvBuilder();
			
			$includes=$formHandler->getReqs();

			$i=0;
			while(isset($includes[$i]))
			{
				$this->head_include($includes[$i]);

				++$i;
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

			$this->appendChild
			(
				$body=new DOMBody()
			);

			$body->appendChild
			(
				$formHandler->buildAll()->form
			);
		}
	}

?>

