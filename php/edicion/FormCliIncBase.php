<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliButtons.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
	
	class FormCliIncBase extends FormCliSelBase
	{
		function __construct($formDirName)
		{
			parent::__construct($formDirName);

			$buttons=new FormCliButtons();

			$this->buttons->appendChild
			(
				new FormCliEdit( FormActions::FORM_ITEM_TYPE_C )
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
				new FormCliAdd( FormActions::FORM_ITEM_TYPE_C , 1 )
			);
		}
	}
?>