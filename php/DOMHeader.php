<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class DOMHeader extends DOMTag
	{
		function __construct()
		{
			parent::__construct('div');

			$this->classList->add('header');
		}
	}
?>