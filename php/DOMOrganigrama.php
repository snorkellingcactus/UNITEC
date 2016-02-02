<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabUl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Arbol.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ArbolLabsActions.php';

	class DOMOrganigrama extends DOMLabUl
	{
		public $arbol;

		function __construct()
		{
			parent::__construct();

			$this->classList->add('organigrama');

			$this->arbol=new Arbol
			(
				new ArbolLabsActions($this)
			);
		}
		function solveDeps($sqlArray , $parentKey)
		{
			$this->arbol->solveDeps($sqlArray , 'PadreID' , 'ID' , $parentKey);
		}
		function renderChilds(&$doc , &$tag)
		{
			$this->arbol->render();

			return parent::renderChilds($doc , $tag);
		}
	}
?>