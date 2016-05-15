<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecBase.php';

	class LabelsSec extends LabelsSecBase
	{
		public $titulo;
		public $atajo;
		public $aaMenu;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAtajo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAAMenu.php';

			$this->appendChild
			(
				$this->titulo=new FormLabelTitulo()
			)->appendChild
			(
				$this->atajo=new FormLabelAtajo()
			)->appendChild
			(
				$this->aaMenu=new FormLabelAAMenu()
			);

			$this->setParentStr('IS NULL');
		}
	}
?>