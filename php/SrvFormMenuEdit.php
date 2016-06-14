<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';

	//Se usa repeatedForm en vez de stepForm por problemas con OOP, para tener una base de código común.
	class SrvFormMenuEdit extends SrvStepRepeatedForm
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Editar Opción ') );
		}
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
			$this->labels->url->input->setValue
			(
				getTraduccion
				(
					$opcion->UrlID ,
					$_SESSION['lang']
				)
			);
			$this->labels->visible->input->controller->setValueToSelect($opcion->Visible);
			//$this->form->autocomp['Prioridad']=$opcion['Prioridad'];

			$this->labels->titulo->input->setValue
			(
				getTraduccion
				(
					strval( $this->labels->getContentID() ) ,
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
				$this->labels->labelTags->input->setValue
				(
					getTagsStr($grupoID[0][0])
				);
			}
		}
	}
?>