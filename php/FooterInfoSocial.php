<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfoBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';

	class FooterInfoSocial extends DOMTag
	{
		function __construct($text , $imgSrc , $linkUrl)
		{
			parent::__construct('div');

			$link=new DOMLink();

			$base=new FooterInfoBase
			(
				$imgSrc,
				sprintf
				(
					gettext('Página de %s'),
					$text
				)
			);

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
			)->classList->add('FooterInfoSocial');
		}
	}
?>