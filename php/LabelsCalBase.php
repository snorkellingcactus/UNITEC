<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCommon.php';

	class LabelsCalBase extends LabelsCommon
	{
		public $titulo;
		public $fecha;
		public $descripcion;
		public $prioridad;
		

		//public $con;

		function __construct(&$index)
		{
			parent::__construct($index);
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelFecha.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelDescripcion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';
			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			//global $con;

			$this->appendChild
			(
				$this->titulo=new FormLabelTitulo()
			)->appendChild
			(
				$this->fecha=new FormLabelFecha()
			)->appendChild
			(
				$this->descripcion=new FormLabelDescripcion()
			)->appendChild
			(
				$this->prioridad=new FormLabelPrioridad()
			);
		}
	}
?>