<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	
	class FormLabelBoxBase extends DOMTag
	{
		public $label;
		public $boxClassName;

		//FormLabelBox::__construct([$name [, $id [, $label [, $input]]]])
		function __construct()
		{
			parent::__construct( 'div' );

			$this->setBoxClassName( 'FormLabelBox' );

			$this->appendChild
			(
				$this->label=$this->newLabel()
			);
		}
		function newLabel()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabel.php';

			return new FormLabelBase();
		}
		function renderChilds( &$tag )
		{
			$this->addToAttribute( 'class' , $this->boxClassName );

			return parent::renderChilds( $tag );
		}
		function setBoxClassName( $class )
		{
			$this->boxClassName=$class;
		}
		function setLabelName( $name )
		{
			$this->label->setTagValue( $name );
		}
/*
		function setLabelID( $labelID )
		{
			$this->label->setID( $labelID );
		}
*/
	}
?>