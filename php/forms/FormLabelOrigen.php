<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelOrigen extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Origen' , 'origen' , gettext('Origen'));

			$this->input->setPlaceHolder(gettext('Calle, Ciudad , Estado'));
		}
	}
?>