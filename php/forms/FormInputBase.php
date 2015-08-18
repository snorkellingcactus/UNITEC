<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	class FormInputBase extends DOMTag
	{
		public $requiere;
		public $label;

		//$padreOTagName, $name , $id
		function __construct()
		{
			parent::__construct();

			$this->label=false;

			$args=func_get_args();
			if(isset($args[0]))
			{
				$argA=$args[0];
				if($argA instanceof FormContainer)
				{
					$argA->appendLabel($this);
				}
				else
				{
					$this->setTagName($argA);
				}
			}
			if(isset($args[1]))
			{
				$this->setName($args[1]);
			}
			if(isset($args[2]))
			{
				$this->setID($args[2]);
			}
		}
		public function setName($name)
		{
			$this->tag->setAttribute('name',$name);

			return $this;
		}
		public function getName()
		{
			$this->tag->getAttribute('name');
		}
		public function setValue($value)
		{
			$this->tag->setAttribute('value' , $value);

			return $this;
		}
		public function setID($id)
		{
			$this->tag->setAttribute('id' , $id);

			if($this->label!==false)
			{
				$this->label->setFor($id);
			}

			return $this;
		}
		public function appendLabel($label)
		{
			$this->label=$label;

			if($this->tag->hasAttribute('id'))
			{
				$label->setFor($this->tag->getAttribute('id'));
			}

			return $this;
		}
	}
?>