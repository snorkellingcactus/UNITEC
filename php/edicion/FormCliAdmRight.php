<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';

	class FormCliAdmRight extends FormCliAdmBase
	{
		function __construct($formDirName)
		{
			parent::__construct($formDirName);

			$this->addToAttribute('class' , 'right');
		}
	}
?>