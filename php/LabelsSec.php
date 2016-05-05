<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecBase.php';

	class LabelsSec extends LabelsSecBase
	{
		public $titulo;
		public $atajo;

		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAtajo.php';

			$this->appendChild
			(
				$this->titulo=new FormLabelTitulo()
			)->appendChild
			(
				$this->atajo=new FormLabelAtajo()
			);

			$this->setParentStr('IS NULL');
		}
	}
?>