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
	class Formatter_Attr_ID
	{
		private $suffix;
		private $preffix;

		function __construct(&$suffix)
		{
			$this->setPreffix(false);
			$this->setSuffix($suffix);
		}
		public function hasSetted()
		{
			return $this->preffix!==false;
		}
		public function getFormatted()
		{
			if($this->hasSetted())
			{
				return $this->getPreffix().$this->getFormattedSuffix();
			}
		}
		public function setPreffix($preffix)
		{
			$this->preffix=$preffix;

			return $this;
		}
		public function setSuffix(&$suffix)
		{
			$this->suffix=$suffix;
		}
		public function getPreffix()
		{
			return $this->preffix;
		}
		public function getSuffix()
		{
			return $this->suffix;
		}
		public function getFormattedSuffix()
		{
			return $this->getSuffix();
		}
	}
	class Formatter_Attr_Name extends Formatter_Attr_ID
	{
		public function getFormattedSuffix()
		{
			return '['.parent::getFormattedSuffix().']';
		}
	}

	class FormMultipleElement extends Requirer
	{
		public $name;
		public $id;
		public $index;

		function __construct()
		{
			parent::__construct();

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setTagName($args[0]);
			}

			$this->index=0;
			$this->id=new Formatter_Attr_ID($this->index);
			$this->name=new Formatter_Attr_Name($this->index);
		}

		public function setName($name)
		{
			$this->name->setPreffix($name);

			return $this;
		}
		public function getName()
		{
			return $this->name->getPreffix();
		}
		public function setID($id)
		{
			$this->id->setPreffix($id);

/*
			//Revisar. Cambiar a un sistema de eventos, donde se emiten.
			if($this->label!==false)
			{
				$this->label->setFor($this);
			}
*/
			return $this;
		}
		public function getID()
		{
			return $this->id->getPreffix();
		}
		public function &getIDReference()
		{
			return $this->id;
		}
		public function setIndex($index)
		{
			$this->index=$index;

			$this->id->setSuffix($index);
			$this->name->setSuffix($index);
		}
		public function renderChilds(&$tag)
		{
			if($this->name->hasSetted())
			{
				$this->setAttribute(	"name"	, $this->name->getFormatted()	);
			}
			if($this->id->hasSetted())
			{
				$this->setAttribute(	"id"	, $this->id->getFormatted()		);
			}

			return parent::renderChilds($tag);
		}
	}
	
	class FormInputBase extends FormMultipleElement
	{
		function __construct()
		{
			$this->label=false;
			
			$args=func_get_args();
			if(isset($args[0]))
			{
				parent::__construct($args[0]);
			}
			else
			{
				parent::__construct();
			}

			if(isset($args[1]))
			{
				$this->name->setPreffix($args[1]);
			}
			if(isset($args[2]))
			{
				$this->id->setPreffix($args[2]);
			}
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
		public function setPlaceHolder($placeHolder)
		{
			return $this->setAttribute('placeholder' , $placeHolder);
		}
	}
?>