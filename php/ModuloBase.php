<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';

	class ModuloBase extends DOMTag
	{
		public $htmlID;
		public $addSep;

		function __construct($tagName)
		{
			parent::__construct($tagName);

			$this->setAddSep(false);
		}
		function appendForm($form)
		{
			if($this->addSep!==false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSep.php';

				$this->appendChild(new FormCliSep());
			}
			$this->appendChild
			(
				$form
			);

			return $this;
		}
		function setAddSep($addSep)
		{
			$this->addSep=$addSep;

			return $this;
		}
		function setHTMLID($htmlID)
		{
			$this->htmlID=$htmlID;

			return $this;
		}
		function renderChilds(&$doc , &$tag)
		{
			if(!empty($this->htmlID))
			{
				$this->setAttribute('id' , $this->htmlID);
			}

			return parent::renderChilds($doc , $tag);
		}
	}
?>