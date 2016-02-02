<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HeadLink.php';

	class StylesHeet extends HeadLink
	{
		function __construct()
		{
			call_user_func_array
			(
				['parent' , '__construct'],
				func_get_args()
			);

			$this->setRel('stylesheet')->setType('text/css');
		}
	}
?>