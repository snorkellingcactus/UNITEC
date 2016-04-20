<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

	class FormCliColAB extends DOMTagContainer
	{
		public $colA;
		public $colB;
		public $sep;

		function __construct()
		{
			parent::__construct();

			$this->colA=false;
			$this->colB=false;
			$this->sep=false;
		}
		public function setColA($value)
		{
			$this->colA=$value;

			return $this;
		}
		public function setColB($value)
		{
			$this->colB=$value;

			return $this;
		}
		public function appendCol($col)
		{
			if($col!==false)
			{
				$this->appendChild($col);
			}
			return $this;
		}
		public function renderChilds(&$tag)
		{
			$this->appendCol
			(
				$this->sep
			)->appendCol
			(
				$this->colA
			)->appendCol
			(
				$this->colB
			);

			return parent::renderChilds($tag);
		}
	}
?>