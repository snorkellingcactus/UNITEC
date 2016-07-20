<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

	class FooterInfoSocial extends DOMTag
	{
		function __construct($text , $imgSrc , $linkUrl)
		{
			parent::__construct('li');

			$link=new DOMLink();

			$link->addToAttribute('class' , 'focuseable');

			$base=new FooterInfoBase( $imgSrc );

			$base->text->setTagValue($text);

			$this->appendChild
			(
				$link->setUrl
				(
					$linkUrl
				)->setOpensNewWindow
				(
					true
				)->appendChild
				(
					$base	
				)
			)->addToAttribute('class' , 'FooterInfoSocial');
		}
	}
?>