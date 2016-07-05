<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInputBase.php';
	
	class FormTxtArea extends FormInputBase
	{
		public function __construct()
		{
			parent::__construct( 'textarea' );
		}
		public function setCols($colsLen)
		{
			return $this->setAttribute('cols' , $colsLen);
		}
		public function setRows($rowsLen)
		{
			return $this->setAttribute('rows' , $rowsLen);
		}
		public function setValue($value)
		{
			return $this->setTagValue( html_entity_decode( $value ) );
		}
	}
?>