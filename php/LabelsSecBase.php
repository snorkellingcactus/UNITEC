<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCommon.php';

	class LabelsSecBase extends LabelsCommon
	{
		public $selectLugar;
		private $padreIDStr;
		public $con;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';

			$this->appendChild
			(
				$this->selectLugar=new FormLabelLugar()
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
						'	SELECT Secciones.TituloID, Secciones.ID, Secciones.PrioridadesGrpID
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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$s=0;
			$j=1;
			while(isset($seccs[$s]))
			{
				$sec=$seccs[$s];
				$titulo=$j;

				if(!isset($sec['TituloID']))
				{
					++$j;
				}
				else
				{
					$titulo=getTraduccion
					(
						$sec['TituloID'],
						$_SESSION['lang']
					);
				}

				$seccs[$s]=array
				(
					$titulo,
					$sec['ID']
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