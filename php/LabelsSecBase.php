<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsSecBase extends DOMLabelsCollection
	{
		public $visible;
		public $selectLugar;
		public $labelTags;
		private $padreIDStr;
		public $con;

		function __construct()
		{
			parent::__construct(0);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

			$this->appendChild
			(
				$this->visible=new FormLabelVisible()
			)->appendChild
			(
				$this->selectLugar=new FormLabelLugar()
			)->appendChild
			(
				$this->labelTags=new FormLabelTags()
			);

			$this->con=$con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
		}

		function setParentStr($parentStr)
		{
			$seccs=getPriorizados
			(
				fetch_all
				(
					$this->con->query
					(
						'	SELECT Secciones.HTMLID, Secciones.ID, Secciones.PrioridadesGrpID
							FROM Secciones
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Secciones.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE Secciones.PadreID '.$parentStr.'
							AND TagsTarget.TagID=Laboratorios.TagID
						'
					),
					MYSQLI_ASSOC
				)
			);

			$s=0;
			while(isset($seccs[$s]))
			{
				$seccs[$s]=array
				(
					$seccs[$s]['HTMLID'],
					$seccs[$s]['ID']
				);
				++$s;
			}

			$this->selectLugar->setOptionsFromSQLRes
			(
				$seccs
			);
		}
	}
?>