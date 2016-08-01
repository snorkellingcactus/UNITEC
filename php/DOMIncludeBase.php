<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMModulo.php';

	class DOMIncludeBase extends DOMModulo
	{
		public $limit;
		public $sID;
		public $mID;
		public $opcGrpID;
		public $opcSetsID;

		function __construct()
		{
			parent::__construct();

			$this
			->setLimited(false)
			->setLimit(false)
			->setSectionID(false)
			->setModuloID(false)
			->setOpcGrpID(false)
			->setOpcSetsID(false)
			->addToAttribute('class' , 'contenido');
		}
		public function setLimited( $limited )
		{
			$this->limited=$limited;

			return $this;
		}
		public function isLimited()
		{
			return $this->limited;
		}
		public function setLimit( $limit )
		{
			$this->limit=$limit;

			return $this;
		}
		public function getLimit()
		{
			return $this->limit;
		}
		public function setSectionID( $sID )
		{
			$this->sID=$sID;

			return $this;
		}
		public function setModuloID( $mID )
		{
			$this->mID=$mID;

			return $this;
		}
		public function setOpcGrpID( $opcGrpID )
		{
			$this->opcGrpID=$opcGrpID;

			return $this;
		}
		public function setOpcSetsID( $opcSetsID )
		{
			$this->opcSetsID=$opcSetsID;

			return $this;
		}
		public function load( $modName )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

			$modName='Modulo_'.$modName;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/'.$modName.'.php';

			$module=new $modName;

			return $this->appendChild
			(
				$module
				->setSectionID( $this->sID )
				->setModuloID( $this->mID )
				->setOpcGrpID( $this->opcGrpID )
				->setOpcSetsID( $this->opcSetsID )
				->setLimit( $this->getLimit() )
				->setLimited( $this->isLimited() )
				->calcLimit()
			)->appendChild
			(
				new ClearFix()
			);
		}
	}
?>