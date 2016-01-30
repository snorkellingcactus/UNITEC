<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliBuscarRuta extends FormCliAddBase
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , gettext('Buscar ruta') , 1);

			$this->setID('buscar')->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
		}
	}
?>