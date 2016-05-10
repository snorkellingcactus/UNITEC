<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormGalEdit extends SrvStepRepeatedForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsGalBase.php';
			
			return new LabelsGalBase($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';

			global $con;

			$imagen=new Img(NULL , $con);
			$imagen->getSQL
			(
				[
					'TituloID'=>$this->labels->getContentID()
				]
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$grupoID=$imagen->getTagsGrp();

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

			

			$this->labels->archivo->inputUrl->input->setValue($imagen->Url);

			$this->labels->visible->input->controller->setValueToSelect
			(
				intVal
				(
					$imagen->Visible
				)
			);

			$this->labels->prioridad->input->setValue
			(
				getSQLObjPriority
				(
					$imagen->PrioridadesGrpID,
					$_SESSION['lab']
				)
			);

			$this->labels->alt->input->setValue
			(
				getTraduccion
				(
					$imagen->AltID,
					$_SESSION['lang']
				)
			);

			$this->labels->titulo->input->setValue
			(
				getTraduccion
				(
					$imagen->TituloID,
					$_SESSION['lang']
				)
			);
		}
	}
?>