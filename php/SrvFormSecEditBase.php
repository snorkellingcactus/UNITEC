<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';
	
	class SrvFormSecEditBase extends SrvStepForm
	{
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Seccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$this->labels->selectLugar->input->controller->setValueToSelect( $this->labels->getContentID() );

			$grupoID=new Seccion
			(
				[
					'ID'=>$this->labels->getContentID()
				] ,
				$this->con
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

			//Revisar metodo correcto
			$this->labels->visible->input->controller->setValueToSelect
			(
				intVal
				(
					fetch_all
					(
						$this->con->query
						(
							'	SELECT Visible
								FROM Secciones
								WHERE ID='.$this->labels->getContentID()
						),
						MYSQLI_NUM
					)[0][0]
				)
			);
/*
			else
			{
				echo '<pre>No group</pre>';
			}
*/
		}
	}
?>