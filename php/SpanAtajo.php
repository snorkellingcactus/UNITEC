<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class SpanAtajo extends DOMTag
	{
		function __construct($atajo)
		{
			parent::__construct('span' , $atajo);

			$this->classList->add('atajo');
		}
	}
?>