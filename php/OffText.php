<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class OffText extends DOMTag
	{
		function __construct()
		{
			call_user_func_array
			(
				['parent' , '__construct'],
				func_get_args()
			);

			$this->addToAttribute('class' , 'offscreen');
		}
	}
?>