<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLabelsCollection.php';

	class LabelsMenu extends DOMLabelsCollection
	{
		public $titulo;
		public $url;
		public $tags;
		public $lugar;
		public $visible;

		//public $con;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			//$this->con=$con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrl.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$this->appendChild
			(
				$this->titulo=new FormLabelTitulo()
			)->appendChild
			(
				$this->url=new FormLabelUrl()
			)->appendChild
			(
				$this->lugar=new FormLabelLugar()
			)->appendChild
			(
				$this->visible=new FormLabelVisible()
			)->appendChild
			(
				$this->tags=new FormLabelTags()
			);

			$this->visible->input->controller->setValueToSelect(1);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
			$lleno=getPriorizados
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT Menu.ContenidoID, Menu.ContenidoID, Menu.PrioridadesGrpID
							FROM Menu
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Menu.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE TagsTarget.TagID=Laboratorios.TagID
						'
					),
					MYSQLI_ASSOC
				)
			);

			$i=0;
			while(isset($lleno[$i]))
			{
				
				$conID=$lleno[$i]['ContenidoID'];

				$lleno[$i]=array
				(
					getTraduccion
					(
						 $conID ,
						 $_SESSION['lang']
					),
					$conID
				);

				++$i;
			}

			$this->lugar->setOptionsFromSQLRes
			(
				$lleno
			);
		}
	}
?>