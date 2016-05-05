<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecOther.php';

	class LabelsSecCon extends LabelsSecOther
	{
		public $contenido;

		function __construct()
		{
			parent::__construct();

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