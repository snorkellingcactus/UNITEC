<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBase.php';
	
	class FormCliCompactBase extends FormCliBase
	{
		function __construct()
		{
			call_user_func_array
			(
				[
					'parent',
					'__construct'
				],
				func_get_args()
			);

			$this->classList->add('FormCliCompactBase');
		}
		function appendLabel($label)
		{
			$label->classList->add('label');

			$label->input->setMulti(0)->col=['xs'=>12 , 'sm'=>7 , 'md'=>7 , 'lg'=>7];	
			$label->label->col=['xs'=>12 , 'sm'=>5 , 'md'=>5 , 'lg'=>5];	

			return parent::appendChild($label);
		}
	}
?>