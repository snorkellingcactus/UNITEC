<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoTextBase.php';

	class FooterInfoText extends FooterInfoTextBase
	{
		function __construct($text , $imgSrc , $imgAlt)
		{
			parent::__construct($imgSrc , $imgAlt);

			$this->base->text->setTagValue($text);
		}
	}
?>