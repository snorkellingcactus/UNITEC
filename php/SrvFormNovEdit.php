<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormNovEdit extends SrvStepRepeatedForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsNovBase.php';
			
			return new LabelsNovBase($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			global $con;

			$novedad=fetch_all
			(
				$con->query
				(
					'	SELECT * 
						FROM Novedades 
						WHERE ID='.$this->labels->getContentID()
				),
				MYSQLI_ASSOC
			)[0];

			$this->labels->selectImg->controller->setValueToSelect( $novedad['ImagenID'] );

			//Revisar. Está raro.

			$grupoID=new Novedad
			(
				[
					'ID'=>$this->labels->getContentID()
				],
				$con
			);

			$grupoID=$grupoID->getTagsGrp();

			if(isset($grupoID[0][0]))
			{
				$this->labels->labelTags->input->setValue
				(
					getTagsStr
					(
						$grupoID[0][0]
					)
				);
			}
			else
			{
				echo '<pre>No group</pre>';
			}

			$this->labels->visible->input->controller->setValueToSelect( $novedad['Visible'] );

			$this->labels->prioridad->input->setValue
			(
				getSQLObjPriority
				(
					$novedad['PrioridadesGrpID'],
					$_SESSION['lab']
				)
			);

			$this->labels->descripcion->input->setValue
			(
				getTraduccion
				(
					$novedad['DescripcionID'] ,
					$_SESSION['lang']
				)
			);

			$this->labels->titulo->input->setValue
			(
				getTraduccion
				(
					$novedad['TituloID'] ,
					$_SESSION['lang']
				)
			);
		}
	}
?>