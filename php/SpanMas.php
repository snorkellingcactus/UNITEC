<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class SpanMas extends DOMTag
	{
		function __construct()
		{
			parent::__construct('span' , '+');

			$this->addToAttribute('class' , 'mas');
		}
	}
?>