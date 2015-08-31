<?php
	class FormGal extends Form
	{
		public $srvBuilder;
		function __construct($srvBuilder)
		{
			parent::__construct($srvBuilder);

			$this->idSuffix=0;

			if(isset($_POST['conID']))
			{
				$this->cantidad=count($_POST['conID']);
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelArchivo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAlt.php';
			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';

			$titulo=new FormLabelTitulo($this);
			$archivo=new FormLabelArchivo($this);
			$alt=new FormLabelAlt($this);
			$visible=new FormLabelVisible($this);

			$this->appendChild($titulo)
			->appendChild(new ClearFix())
			->appendChild($alt)
			->appendChild(new ClearFix())
			->appendChild($visible)
			->appendChild(new ClearFix())
			->appendChild($archivo);
		}
	}
?>