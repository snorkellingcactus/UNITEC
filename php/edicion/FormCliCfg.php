<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliCfg extends FormSecBtn
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm , 'configura' ,gettext('Configurar')
			);
		}
	}
?>