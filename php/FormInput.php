<?php
	function print_bool($bool)
	{
		if($bool)
		{
			return 'true';
		}
		return 'false';
	}
	class DOMClassList
	{
		public $padre;
		public $attrLst;
		private $count;

		function __construct(DOMElement $padre)
		{
			$this->padre=$padre;
			$this->attrLst=[];
			$this->count=0;
		}
		function add($name)
		{
			if(array_key_exists($name, $this->attrLst))
			{
				return;
			}

			$this->attrLst[$this->count]=$name;

			++$this->count;

			return $this->applyAttrLst();
		}
		function del($name)
		{
			$attrLst=[];
			$count=0;
			foreach($this->attrLst as $key=>$value)
			{
				if($value!==$name)
				{
					$attrLst[$count]=$value;
					++$count;
				}
			}
			$this->attrLst=$attrLst;

			if(empty($attrLst) && $this->padre->hasAttribute('class'))
			{
				$this->padre->removeAttribute('class');
				return $this;
			}
			else
			{
				return $this->applyAttrLst();
			}
		}
		function applyAttrLst()
		{
			$this->padre->setAttribute
			(
				'class',
				implode(' ' , $this->attrLst)
			);

			return $this;
		}
	}
	class FormContainer extends DOMTag
	{

		function __construct()
		{
			parent::__construct();
		}
	}
	class DOMTag
	{
		public $domDoc;
		public $tag;
		public $classList;
		public $value;
		public $col;
		public $all;
		public $hijos;
		public $hijosLen;

		function __construct()
		{
			$this->domDoc=new DOMDocument;

			$this->all=$this->col=
			[
				'xs'=>false,
				'sm'=>false,
				'md'=>false,
				'lg'=>false
			];
			$this->hijos=[];
			$this->hijosLen=0;

			$args=func_get_args();
			if(isset($args[0]))
			{
				$this->setTagName($args[0]);
			}
			if(isset($args[1]))
			{
				$this->setTagValue($args[1]);
			}
		}
		function appendChild(DOMTag $domTag)
		{
			$this->hijos[$this->hijosLen]=& $domTag;

			++$this->hijosLen;

			return $this;
		}
		public function setTagName($tagName)
		{
			$this->tag=$this->domDoc->createElement($tagName);
			$this->domDoc->appendChild($this->tag);

			$this->classList=new DOMClassList($this->tag);

			return $this;
		}
		public function setTagValue($val)
		{
			$this->tag->appendChild($this->domDoc->createTextNode($val));

			return $this;
		}
		public function render($childs , $childsLen ,  $doc)
		{
			for($i=0;$i<$childsLen;$i++)
			{
				$child=$childs[$i];

				$doc->appendChild
				(
					$this->domDoc->importNode
					(
						$child->renderChilds()->tag ,
						true
					)
				);
			}

			return $this;
		}
		function renderChilds()
		{
			return $this->render($this->hijos , $this->hijosLen , $this->tag);
		}
		public function getHTML()
		{
			$this->renderChilds();

			$innerHTML = ""; 
			$children  = $this->domDoc->childNodes;

			foreach ($children as $child) 
			{
				$innerHTML .= $this->domDoc->saveHTML($child);
			}

			return $innerHTML; 
		}
		public function setBootstrap($cols , $var)
		{
			$thisCols=& $this->$var;
			foreach($cols as $col=>$val)
			{
				$thisCols[$col]=$val;
			}
			$this->applyBootstrap($cols , $var);

			return $this;
		}
		public function setCol($cols)
		{
			$this->setBootstrap($cols , 'col');

			return $this;
		}
		public function setAll($cols)
		{
			$this->setBootstrap($cols , 'all');

			return $this;
		}
		public function applyBootstrap($cols , $var)
		{
			foreach($cols as $col=>$val)
			{
				if($val!==false)
				{
					$this->classList->add($var.'-'.$col.'-'.$val);
				}
			}
		}
		public function applyCol()
		{
			$this->applyBootstrap($this->col , 'col');
		}
		public function applyAll()
		{
			$this->applyBootstrap($this->all , 'all');
		}
	}
	class DOMTagContainer extends DOMTag
	{
		public $hermanos;
		public $hermanosLen;

		function __construct()
		{
			parent::__construct();

			$this->hermanos=[];
			$this->hermanosLen=0;
		}
		function appendTag(DOMTag $domTag)
		{
			$this->hermanos[$this->hermanosLen]=& $domTag;

			++$this->hermanosLen;

			return $this;
		}
		function renderChilds()
		{
			return $this->render($this->hermanos , $this->hermanosLen , $this->domDoc);
		}
	}
	class FormInputBase extends DOMTag
	{
		public $requiere;
		public $label;

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
	class FormInput extends FormInputBase
	{
		function __construct($tipo)
		{
			parent::__construct('input');
			
			$this->tag->setAttribute('type' , $tipo);
		}
	}
	class FormTxtArea extends FormInputBase
	{
		function __construct()
		{
			parent::__construct('textarea');
		}	
	}
	class FormOption extends FormInputBase
	{
		public $selected;

		function __construct()
		{
			parent::__construct('option');

			$args=func_get_args();
			if(isset($args[0]))
			{
				$this->setTagValue($args[0]);
			}
			if(isset($args[1]))
			{
				$this->setValue($args[1]);
			}
		}
		function setSelected($bool)
		{
			$this->selected=$bool;
			$this->tag->setAttribute('selected' , print_bool($bool));

			return $this;
		}
		function getSelected()
		{
			return $this->selected;
		}
	}
	class FormSelect extends FormInputBase
	{
		public $options;
		public $optionsLen;

		function __construct()
		{
			parent::__construct('select');

			$this->options=[];
			$this->optionsLen=0;
		}
		function addOption(FormOption $option)
		{
			$this->options[$this->optionsLen]=$option;
			++$this->optionsLen;

			$this->appendChild($option);

			return $this;
		}
	}
	class FormSelectBool extends FormSelect
	{
		function __construct($labelA , $labelB)
		{
			parent::__construct();

			$default=false;
			$args=func_get_args();
			if(isset($args[2]))
			{
				$default=$args[2];
			}
			$this->addOption(new FormOption($labelA , print_bool($default)));
			$this->addOption(new FormOption($labelB , print_bool(!$default)));
		}
	}
	class FormLabel extends DOMTag
	{
		function __construct()
		{
			parent::__construct();

			$this->setTagName('label');

			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->setTagValue($args[0]);
			}
		}
		function setFor($id)
		{
			$this->tag->setAttribute('for' , $id);
		}
	}
	//Un input con label.
	class FormLabelBox extends DOMTagContainer
	{
		public $label;
		public $input;
		public $name;
		public $id;

		//FormLabelBox::__construct([$name [, $id [, $label [, $input]]]])
		function __construct()
		{
			
			parent::__construct();

			$this->label=new FormLabel();


			$args=func_get_args();
			if(isset($args[2]))
			{
				$this->name=$args[0];
				$this->id=$args[1];

				$this->setLabelName($args[2]);
			}

			$this->appendTag($this->label);

			if(isset($args[3]))
			{
				$this->setInput($args[3]);
			}
			
		}
		function setInput($input)
		{
			$this->input=$input;
			$this->appendTag
			(
				$input->
				setID($this->id)->
				setName($this->name)->
				appendLabel($this->label)
			);
		}
		function setLabelName($name)
		{
			$this->label->setTagValue($name);
		}
	}
	/*
	class FormDate extends FormContainer
	{
		public $lBoxAno;

		function __construct($namePrefix , $idPrefix)
		{
			$this->lBoxAno=new FormLabelBox();
			$args=func_get_args();

			if(isset($args[0]))
			{
				$this->input=new FormInput($args[3]);
			}
		}
	}
	*/
	//class FormTxtArea
	//class FormTxtDateMon
?>