<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUNormal.php';

	class DOMHTMLVisores extends HTMLUNormal
	{
		public $body;

		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

			$this->head_include
			(
				'/forms/forms.css'
			)->head_include
			(
				'/seccs/visor.css'
			)->head_include
			(
				'/seccs/galeria.css'
			);
		}
		function renderChilds(&$doc , &$tag)
		{
			return parent::renderChilds($doc , $tag);
		}
	}
?>