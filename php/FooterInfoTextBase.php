<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoBase.php';

	class FooterInfoTextBase extends DOMTag
	{
		public $base;

		function __construct($imgSrc , $imgAlt)
		{
			parent::__construct('p');

			$this->appendChild
			(
				$this->base=new FooterInfoBase($imgSrc , $imgAlt)
			);

			$this->classList->add('FooterInfoTextBase');
		}
	}
?>