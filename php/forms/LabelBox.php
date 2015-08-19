<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';
	
	class LabelBox extends FormLabelBox
	{
		function __construct()
		{
			call_user_func_array
			(
				array('parent', '__construct'),
				func_get_args()
			);

			$this->input->setCol
			(
				[
					'xs'=>7,
					'sm'=>7,
					'md'=>7,
					'lg'=>7
				]
			);
			$this->label->setCol
			(
				[
					'xs'=>5,
					'sm'=>5,
					'md'=>5,
					'lg'=>5
				]
			);
		}
	}
?>