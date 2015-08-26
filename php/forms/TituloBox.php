<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';
	
	class TituloBox extends FormLabelBox
	{
		function __construct()
		{
			call_user_func_array
			(
				array('parent', '__construct'),
				func_get_args()
			);

			$this->label->setCol
			(
				[
					'xs'=>12,
					'sm'=>12,
					'md'=>12,
					'lg'=>12
				]
			)->classList->add('center');
		}
		function setInput($input)
		{
			parent::setInput($input);

			$this->input->setCol
			(
				[
					'xs'=>12,
					'sm'=>12,
					'md'=>12,
					'lg'=>12
				]
			);
		}
	}
?>