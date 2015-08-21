<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';
	
	class FormInputBase extends FormBase
	{
		public $label;
		public $multi;
		public $parentForm;

		//$padreOTagName, $name , $id
		function __construct($parentForm)
		{
			parent::__construct();

			$this->label=false;
			$this->multi=true;
			$this->parentForm=$parentForm;
			
			$args=func_get_args();

			if(isset($args[1]))
			{

				$argA=$args[1];
				if($argA instanceof FormContainer)
				{
					$argA->appendLabel($this);
				}
				else
				{
					$this->setTagName($argA);
				}
			}
			if(isset($args[2]))
			{
				$this->setName($args[2]);
			}
			if(isset($args[3]))
			{
				$this->setID($args[3]);
			}
		}
		public function setMulti($multi)
		{
			$this->multi=$multi;

			return $this;
		}
		public function getMulti()
		{
			return $this->multi;
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
			if(!isset($this->parentForm))
			{
				echo '<pre>No hay padre</pre>';
				echo '<pre>ID : ';print_r($id);echo '</pre>';
				echo '<pre>Name : ';print_r($this->getName());echo '</pre>';
				echo '<pre>Value : ';print_r($this->getValue);echo '</pre>';
				//echo '<pre> : ';print_r();echo '</pre>';
				//echo '<pre> : ';print_r();echo '</pre>';
				//echo '<pre> : ';print_r();echo '</pre>';
				return $this;
			}

			$this->setAttribute('id' , $id.$this->parentForm->idSuffix);

			if($this->label!==false)
			{
				$this->label->setFor($this);
			}

			return $this;
		}
		public function getID()
		{
			return $this->getAttribute('id');
		}
		public function appendLabel($label)
		{
			$this->label=$label;

			if($this->tag->hasAttribute('id'))
			{
				$label->setFor($this);
			}

			return $this;
		}
	}
?>