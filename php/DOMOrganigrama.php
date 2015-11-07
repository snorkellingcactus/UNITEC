<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabUl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Arbol.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ArbolLabsActions.php';

	class DOMOrganigrama extends DOMLabUl
	{
		function __construct($sqlArray , $parentKey)
		{
			parent::__construct();

			$this->classList->add('organigrama');

			$arbol=new Arbol
			(
				new ArbolLabsActions($this)
			);
			$arbol->solveDeps($sqlArray , 'PadreID' , 'ID' , $parentKey)->render();
		}
	}
?>