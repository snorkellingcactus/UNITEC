<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliIncBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliNumSelect.php';

	class FormCliIncMulti extends FormCliIncBase
	{
		function __construct($formDirName)
		{
			parent::__construct
			(
				$formDirName ,
				new FormCliNumSelect()
			);
		}
	}
?>