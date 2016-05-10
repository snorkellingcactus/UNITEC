<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecOther.php';

	class LabelsSecCon extends LabelsSecOther
	{
		public $contenido;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';

			$this->appendChild
			(
				$this->contenido=new FormLabelContenido()
			);

			/*
				Opciones del modulo - parentID
			*/
		}
	}
?>