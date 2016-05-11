<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCommon.php';

	class LabelsGalBase extends LabelsCommon
	{
		public $titulo;
		public $alt;
		public $archivo;
		public $prioridad;

		function __construct(&$index)
		{
			parent::__construct($index);
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAlt.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrlNov.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';

			$this->appendChild
			(
				$this->titulo=new FormLabelTitulo()
			)->appendChild
			(
				$this->alt=new FormLabelAlt()
			)->appendChild
			(
				$this->archivo=new FormLabelUrlNov()
			)->appendChild
			(
				$this->prioridad=new FormLabelPrioridad()
			);
		}
	}
?>