<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBase.php';

	class FormCliAdmBase extends FormCliBase
	{
		public $buttons;
		
		function __construct($formDirName)
		{
			parent::__construct($formDirName);

			$this->buttons=new FormCliButtons();

			$this->appendChild
			(
				$this->buttons
			);
		}
	}
?>