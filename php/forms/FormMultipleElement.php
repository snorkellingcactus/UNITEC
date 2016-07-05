<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Requirer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/interfaces/Indexable.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Formatter_Attr_ID.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Formatter_Attr_Name.php';

	class FormMultipleElement extends Requirer implements Indexable
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
		public function setID( $id )
		{
			$this->id->setPreffix( $id );

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
		public function getIDReference()
		{
			return $this->id;
		}
		public function setIndex( &$index )
		{
			$this->index=&$index;

			$this->id->setSuffix( $index );
			$this->name->setSuffix( $index );

			return $this;
		}
		public function &getIndex()
		{
			return $this->index;
		}
		public function renderChilds( &$tag )
		{
			if( $this->name->hasSetted() )
			{
				$this->setAttribute(	"name"	, $this->name->getFormatted()	);
			}
			if( $this->id->hasSetted() )
			{
				$this->setAttribute(	"id"	, $this->id->getFormatted()		);
			}

			return parent::renderChilds( $tag );
		}
	}
?>