<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliBuscarRuta extends FormCliAddBase
	{
		function __construct()
		{
			parent::__construct(FormActions::FORM_ITEM_TYPE_A , gettext('Buscar ruta') , 1);

			$this->setID( 'buscar' )->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
		}
	}
?>