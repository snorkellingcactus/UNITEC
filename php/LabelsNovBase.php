<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCommon.php';

	class LabelsNovBase extends LabelsCommon
	{
		public $titulo;
		public $descripcion;

		public $prioridad;
		
		public $selectImg;

		function __construct(&$index)
		{
			parent::__construct($index);
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelImagen.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

			$this->appendChild
			(
				$this->titulo=new FormLabelTitulo()
			)->appendChild
			(
				$this->selectImg=new FormLabelImagen( 'Imagen' , 'imagen' , gettext('Imagen') )
			)->appendChild
			(
				$this->descripcion=new FormLabelContenido()
			)->appendChild
			(
				$this->prioridad=new FormLabelPrioridad()
			);
		}
		function renderChilds(&$tag)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

			$Imgs=getPriorizados
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT Imagenes.ID , Imagenes.TituloID , Imagenes.AltID, Imagenes.PrioridadesGrpID
							FROM Imagenes
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Imagenes.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE TagsTarget.TagID=Laboratorios.TagID
						'
					),
					MYSQLI_ASSOC
				)	//Respuesta SQL como array asociativo.
			);

			$i=0;
			while(isset($Imgs[$i]))
			{
				$imgId=$Imgs[$i]['ID'];

				$this->selectImg->controller->addOption
				(
					$this->selectImg->controller->buildOption
					(
						$imgId
					)->setSrc
					(
						'/img/miniaturas/galeria/'.$imgId.'.png'
					)->setAlt
					(
						getTraduccion
						(
							$Imgs[$i]['AltID'] ,
							$_SESSION['lang']
						)
					)->setTitulo
					(
						getTraduccion
						(
							$Imgs[$i]['TituloID'] ,
							$_SESSION['lang']
						)
					)
				);

				++$i;
			}
			
			return parent::renderChilds($tag);
		}
	}
?>