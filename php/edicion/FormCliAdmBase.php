<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBase.php';

	class FormCliAdmBase extends FormCliBase
	{
		public $buttons;
		
		function __construct($formDirName)
		{
			parent::__construct($formDirName);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliButtons.php';

			$this->buttons=new FormCliButtons();

			$this->appendChild
			(
				$this->buttons
			);
		}
	}
?>