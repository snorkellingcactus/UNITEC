<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMRoleTag.php';

	class DOMLang extends DOMRoleTag
	{
		private $ul;
		private $current;

		function __construct()
		{
			parent::__construct('nav');

			$this->ul=new DOMRoleTag('ul');

			/*:::Nav con role navigation puede duplicar el anuncio de secciones navegables.:::*/
			
			
			$this->ul->setRole( 'menu' );
			$this->setTabindex( 1 )->addToAttribute( 'class' , 'focuseable' );//->setRole( 'navigation' );
		}
		function setCurrent( array $current )
		{
			$this->current=$current;
		}
		function getCurrent()
		{
			return $this->current;
		}
		function applyLang( $option , $langName , $shortLangName )
		{
			$img=new DOMRoleTag( 'img' );

			//Revisar si un alt vacío funciona para que la imagen
			//no sea leída por lectores de pantalla.
			//Código en común con DOMMenuUnitec.

			return $option->appendChild
			(
				$img
				->setHidden( true )
				->setAttribute('src' , '/img/idiomas/'.$shortLangName.'.png')
				->setAttribute('alt' , '')
			)->appendChild
			(
				new DOMTag( 'span' ,  $langName )
			);
		}
		function newBaseOption()
		{
			$nOpt=new DOMRoleTag('li');

			return $nOpt->setRole('menuitem');
		}
		function newLink( $shortLangName )
		{
			$a=new DOMTag('a');

			return $a->setAttribute
			(
				'rel',
				'alternate'
			)->setAttribute
			(
				'href',
				getLabUrl
				(
					getLabName( $_SESSION['lab'] ),
					$shortLangName
				)
			)->setAttribute
			(
				'hreflang',
				$shortLangName
			)->setAttribute
			(
				'lang',
				$shortLangName
			)->setAttribute
			(
				'tabindex',
				1
			)->addToAttribute( 'class' , 'focuseable' );
		}
		function applyCurrentLang( $tag )
		{
			$lang=$this->getCurrent();

			return $this->applyLang
			(
				$tag,
				$lang['Nombre'],
				$lang['Pais'][0].$lang['Pais'][1]
			);
		}
		function newOption( $lang )
		{
			$shortLangName=$lang['Pais'][0].$lang['Pais'][1];

			return $this->newBaseOption()->appendChild
			(
				$this->applyLang
				(
					$this->newLink( $shortLangName ),
					$lang['Nombre'],
					$shortLangName
				)
			);
		}
		function addOption($child)
		{
			$this->ul->appendChild($child);

			return $this;
		}
		function renderChilds( &$tag )
		{
			$this->appendChild( $this->ul );
			return parent::renderChilds( $tag );
		}
	}
?>