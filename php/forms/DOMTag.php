<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagBase.php';

	class DOMTag extends DOMTagBase
	{
		public $tagValue;
		public $col;
		public $all;

		function __construct()
		{
			parent::__construct();

			$this->tagValue=false;

			$this->all=$this->col=
			[
				'xs'=>false,
				'sm'=>false,
				'md'=>false,
				'lg'=>false
			];

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
		public function setTag($tag)
		{
			
			$this->bootstrapApply();

			parent::setTag($tag);

			if($this->tagValue!==false)
			{
				$this->tag->appendChild
				(
					$this->getOwnerDocumentOf($this->parent->getTag())->createTextNode($this->tagValue)
				);
			}

		}
		public function setTagValue($tagValue)
		{
			$this->tagValue=$tagValue;

			return $this;
		}
		private function bootstrapApply()
		{
			$this->bootstrapApplySingle($this->col , 'col');
			$this->bootstrapApplySingle($this->all , 'all');
		}
		private function bootstrapApplySingle($cols , $suffix)
		{
			foreach($cols as $colName=>$val)
			{
				if($val!==false)
				{
					$this->bootstrapAppendClass($suffix , $colName , $val);
				}
			}
		}
		private function bootstrapAppendClass($colType , $colName , $val)
		{
			$this->addToAttribute('class' , $colType.'-'.$colName.'-'.$val);
		}
		public function setBootstrap($cols , &$var)
		{
			foreach($cols as $col=>$val)
			{
				$var[$col]=$val;
			}

			return $this;
		}
		public function &getColRef()
		{
			return $this->col;
		}
		public function &getAllRef()
		{
			return $this->all;
		}
		public function setColRef(&$col)
		{
			$this->col=&$col;
		}
		public function setAllRef(&$col)
		{
			$this->all=&$col;
		}
		//Cambiar a setCols() o eliminar.
		public function setCol($cols)
		{
			return $this->setBootstrap( $cols , $this->col );
		}
		public function setAll($cols)
		{
			return $this->setBootstrap( $cols , $this->all );
		}
	}
?>