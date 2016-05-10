<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';

	class SrvFormMenuEdit extends SrvStepForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenu.php';
			
			return new LabelsMenu($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$opcion=new Menu(null , $this->con);
			$opcion->getSQL
			(
				[
					'ContenidoID'=>$this->labels->getContentID()
				]
			);
	/*
			$opcion=fetch_all
			(
				$con->query
				(
					'	SELECT *
						FROM Menu
						WHERE ContenidoID='.$_POST['conID']
				),
				MYSQLI_ASSOC
			)[0];
	*/
			$this->labels->url->input->setValue($opcion->Url);
			$this->labels->visible->input->controller->setValueToSelect($opcion->Visible);
			//$this->form->autocomp['Prioridad']=$opcion['Prioridad'];

			$this->labels->titulo->input->setValue
			(
				getTraduccion
				(
					strval($this->labels->getContentID()),
					$_SESSION['lang']
				)
			);

			$this->labels->lugar->input->controller->setValueToSelect
			(
				$this->labels->getContentID()
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$grupoID=$opcion->getTagsGrp();

			if(isset($grupoID[0][0]))
			{
				$this->labels->tags->input->setValue
				(
					getTagsStr($grupoID[0][0])
				);
			}
		}
	}
?>