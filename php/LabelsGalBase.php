<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsGalBase extends DOMLabelsCollection
	{
		//public $con;
		public $titulo;
		public $alt;
		public $archivo;
		public $prioridad;
		public $visible;
		public $labelTags;

		function __construct(&$index)
		{
			parent::__construct($index);
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrlNov.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAlt.php';

			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			//global $con;

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
				
			)->appendChild
			(
				$this->visible=new FormLabelVisible()
			)->appendChild
			(
				$this->labelTags=new FormLabelTags()
			);
		}
	}
?>