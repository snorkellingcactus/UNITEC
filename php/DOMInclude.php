<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Modulo.php';

	class DOMInclude extends Modulo
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
			->setLimit(false)
			->setSectionID(false)
			->setModuloID(false)
			->setOpcGrpID(false)
			->setOpcSetsID(false)
			->classList->add('contenido');
		}
		function setLimit($limit)
		{
			$this->limit=$limit;

			return $this;
		}
		function setSectionID($sID)
		{
			$this->sID=$sID;

			return $this;
		}
		function setModuloID($mID)
		{
			$this->mID=$mID;

			return $this;
		}
		function setOpcGrpID($opcGrpID)
		{
			$this->opcGrpID=$opcGrpID;

			return $this;
		}
		function setOpcSetsID($opcSetsID)
		{
			$this->opcSetsID=$opcSetsID;

			return $this;
		}
		function load($modName)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

			$modName='Modulo_'.$modName;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/'.$modName.'.php';

			$module=new $modName;

			return $this->appendChild
			(
				$module
				->setSectionID($this->sID)
				->setModuloID($this->mID)
				->setOpcGrpID($this->opcGrpID)
				->setOpcSetsID($this->opcSetsID)
				->setLimit($this->limit)
			)->appendChild
			(
				new ClearFix()
			);
		}
	}
?>