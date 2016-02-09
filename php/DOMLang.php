<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMRoleTag.php';

	class DOMLang extends DOMRoleTag
	{
		public $ul;

		function __construct()
		{
			parent::__construct('nav');

			$this->ul=new DOMRoleTag('ul');

			$this->appendChild
			(
				$this->ul->setRole('menu')->setTabindex(1)
			)->setRole('navigation');
		}
		function newFirstOption($lang)
		{
			return $this->applyLangImg
			(
				$this->newBaseOption(),
				$lang['Nombre'],
				$lang['Pais'][0].$lang['Pais'][1]
			);
		}
		function newOption($lang)
		{
			$shortLangName=$lang['Pais'][0].$lang['Pais'][1];

			$a=new DOMTag('a');

			$a->setAttribute
			(
				'rel',
				'alternate'
			)->setAttribute
			(
				'href',
				getLabUrl
				(
					getLabName($_SESSION['lab']),
					$shortLangName
				)
			)->setAttribute
			(
				'lang',
				$shortLangName
			)->setAttribute
			(
				'tabindex',
				1
			)->classList->add('focuseable');

			return $this->newBaseOption()->appendChild
			(
				$this->applyLangImg
				(
					$a,
					$lang['Nombre'],
					$shortLangName
				)
			);
		}
		function applyLangImg($option , $langName , $shortLangName)
		{
			$img=new DOMRoleTag('img');

			//Revisar si un alt vacío funciona para que la imagen
			//no sea leída por lectores de pantalla.

			return $option->appendChild
			(
				$img
				->setHidden(true)
				->setAttribute('src' , '/img/idiomas/'.$shortLangName.'.png')
				->setAttribute('alt' , '')
			)->appendChild
			(
				new DOMTag('span' , utf8_encode($langName))
			);
		}
		function newBaseOption()
		{
			$nOpt=new DOMRoleTag('li');

			return $nOpt->setRole('menuitem');
		}
		function addOption($child)
		{
			$this->ul->appendChild($child);

			return $this;
		}
	}
?>