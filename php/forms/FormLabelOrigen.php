<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelOrigen extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Origen' , 'origen' , gettext('Origen'));

			$this->input->setPlaceHolder(gettext('Calle, Ciudad , Estado'));
		}
	}
?>