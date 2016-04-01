<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Requirer.php';

	class ExeptionsUtil
	{
		public function ErrorHandler($name)
		{
			try
			{
				if(gettype($name)!='string')
				{
					throw new Exception("A Non string value passed as name value for a FormInputBase. The type is ".gettype($name));
				}
			}
			catch(Exception $e)
			{
				echo '<pre>';
				print_r('Message: '.$e->getMessage().' '.$e->getTraceAsString());
				echo '</pre>';
			}
		}
	}
	
	class FormInputBase extends Requirer
	{
		public $label;
		public $idSuffix;

		//$padreOTagName, $name , $id
		function __construct()
		{
			parent::__construct();

			$this->label=false;

			$this->idSuffix=0;
			
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
		public function setPlaceHolder($placeHolder)
		{
			return $this->setAttribute('placeholder' , $placeHolder);
		}
		public function setName($name)
		{
			ExeptionsUtil::ErrorHandler($name);
			return $this->setAttribute('name' , $name);
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
			//Revisar.
			if($this->hasAttribute('value'))
			{
				return $this->getAttribute('value');
			}
		}
		public function applyAttributeSuffix($attribute , $suffix)
		{
			if($this->hasAttribute($attribute))
			{
				$this->setAttribute
				(
					$attribute,
					$this->getAttribute($attribute).$suffix
				);
			}
		}
		public function setIDSuffix($idSuffix)
		{
			$this->idSuffix=$idSuffix;
		}
		public function getIDSuffix()
		{
			return $this->idSuffix;
		}
		public function getNameSuffix()
		{
			return '['.$this->getIDSuffix().']';
		}
		public function renderChilds(&$doc , &$tag)
		{
			$this->applyAttributeSuffix("name" , $this->getNameSuffix());
			$this->applyAttributeSuffix("id" , $this->getIDSuffix());
			
			return parent::renderChilds($doc , $tag);
		}
		public function setID($id)
		{
			$this->setAttribute('id' , $id);

			//Revisar. Cambiar a un sistema de eventos, donde se emiten.
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

			if($this->hasAttribute('id'))
			{
				$label->setFor($this);
			}

			return $this;
		}
	}
?>