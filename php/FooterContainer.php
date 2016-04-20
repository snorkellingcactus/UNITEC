<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class FooterContainer extends DOMTag
	{
		function __construct()
		{
			parent::__construct('div');

			$this->addToAttribute('class' , 'FooterContainer');
			$this->col=['xs'=>12 , 'sm'=>6 , 'md'=>6 , 'lg'=>6];
		}
	}
?>