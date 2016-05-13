<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsMapa extends DOMLabelsCollection
	{
		//public $con;
		public $visible;
		public $labelTags;

		function __construct()
		{
			$index=0;
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliBuscarRuta.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelModoViaje.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUnidad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelOrigen.php';

			$ejemplo=new DOMTag('p' , gettext('Ej : Av 1 y 60, La Plata'));
			$ejemplo->col=['xs'=>12 , 'sm'=>7 , 'md'=>7 , 'lg'=>7];
			$ejemplo->addToAttribute('class' , 'ejemplo')->addToAttribute('class' ,'monoWhite');

			$this->appendLabel
			(
				$this->modoViaje=new FormLabelModoViaje()
			)->appendLabel
			(
				$this->unidad=new FormLabelUnidad()
			)->appendLabel
			(
				$this->origen=new FormLabelOrigen()
			)->appendChild
			(
				$ejemplo
			)->appendChild
			(
				$this->buscar=new FormCliBuscarRuta()
			)->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
		}
		function appendLabel($label)
		{
			$label->addToAttribute('class' , 'label');

			$label->input->col=['xs'=>12 , 'sm'=>7 , 'md'=>7 , 'lg'=>7];	
			$label->label->col=['xs'=>12 , 'sm'=>5 , 'md'=>5 , 'lg'=>5];	

			return parent::appendChild($label);
		}
	}

?>
