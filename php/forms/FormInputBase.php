<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';
	
	class FormInputBase extends FormBase
	{
		public $label;
		public $multi;

		//$padreOTagName, $name , $id
		function __construct()
		{
			parent::__construct();

			$this->label=false;
			$this->multi=true;

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
			$multi='';
			if($this->multi)
			{
				$multi='[]';
			}
			return $this->setAttribute('name',$name.$multi);
		}
		public function getName()
		{
			return $this->getAttribute('name');
		}
		public function setValue($value)
		{
			return $this->setAttribute('value' , $value);
		}
		public function getValue()
		{
			return $this->getAttribute('value');
		}
		public function setID($id)
		{
			$this->setAttribute('id' , $id);

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