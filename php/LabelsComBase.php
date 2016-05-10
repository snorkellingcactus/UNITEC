<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsComBase extends DOMLabelsCollection
	{
		public $nombre;
		public $descripcion;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelNombre.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelMensaje.php';

			$this->appendChild
			(
				$this->nombre=new FormLabelNombre()	
			)->appendChild
			(
				$this->descripcion=new FormLabelMensaje()
			);
		}
	}
?>