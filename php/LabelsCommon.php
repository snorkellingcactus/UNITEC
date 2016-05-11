<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsCommon extends DOMLabelsCollection
	{
		//public $con;
		public $visible;
		public $labelTags;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

			$this->visible=new FormLabelVisible();
			$this->labelTags=new FormLabelTags();
		}

		function renderChilds(&$tag)
		{

			$this->appendChild
			(
				$this->visible
			)->appendChild
			(
				$this->labelTags
			);

			return parent::renderChilds($tag);
		}
	}

?>
