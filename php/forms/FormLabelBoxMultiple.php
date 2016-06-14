<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/Indexable.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBoxBase.php';

	class FormLabelBoxMultiple extends FormLabelBoxBase implements Indexable
	{
		public $lBoxList;
		public $lBoxListLen;
		//public $contenedor;
		private $index;

		function __construct()
		{
			parent::__construct();

			$this->lBoxList=array();
			$this->lBoxListLen=0;
/*
			$this->appendChild
			(
				$this->contenedor=new DOMTag('div')
			);
*/
			//$this->contenedor->col	=['xs'=>12	, 'sm'=>12	, 'md'=>12	, 'lg'=>12	];
		}

		//Revisar efectos secundarios de &
		public function appendLBox($lBox)
		{
			//Quizá esto sea tarea del lBox...
			$this->appendInput($lBox->input);

			//$this->contenedor->appendChild($lBox);
			return $this;
		}
		public function appendInput($input)
		{
			$input->addReferenceToAttr
			(
				'aria-labelledby' ,
				$this->label->getIDReference()->getFormatted()
			);
		}
		function renderChild(&$child)
		{	
			if($child instanceof Indexable)
			{
				$child->setIndex
				(
					$this->index
				);
			}

			return parent::renderChild($child);
		}
		public function setIndex( &$index )
		{
			$this->index=&$index;
		}
	}
?>