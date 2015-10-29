<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliButtons.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	
	class FormCliIncBase extends FormCliSelBase
	{
		function __construct($formDirName)
		{
			parent::__construct($formDirName);

			$buttons=new FormCliButtons();

			$this->buttons->appendChild
			(
				new FormCliEdit($this)
			)->appendChild
			(
				$buttons->appendChild
				(
					new DOMTag
					(
						'span',
						gettext('Acciones:')
					)
				)
			);

			$args=func_get_args();
			if(isset($args[1]))
			{
				$buttons->appendChild($args[1]);
			}

			$buttons->appendChild
			(
				new FormCliAdd($this , 1)
			);
		}
	}
?>