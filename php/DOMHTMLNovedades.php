<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTMLUnitecBase.php';

	class DOMHTMLNovedades extends DOMHTMLUnitecBase
	{
		public $body;

		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBodyNovedades.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

			$this->body=new DOMBodyNovedades();

			$this->head_include
			(
				'/forms/forms.css'
			)->head_include
			(
				'/seccs/visor.css'
			)->head_include
			(
				'/seccs/galeria.css'
			)->appendChild
			(
				$this->body
			)->head_include
			(
				'/seccs/novedades.css'
			)->setDescription
			(
				gettext('Grupo de novedades de unitec.')
			)->setTitle
			(
				getLabName()
			);
		}
	}
?>