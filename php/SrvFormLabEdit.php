<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormLabEdit extends SrvStepRepeatedForm
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Editar Laboratorio ') );
		}
		function newLabelsCollection( &$index )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsLabBase.php';
			
			return new LabelsLabBase($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			global $con;

			$contentIDAct=FormActions::getContentID()[0];

			$lab=new Laboratorio(null , $con);
			$lab->getSQL
			(
				[
					'ID'=>$contentIDAct
				]
			);

			$this->labels->ubicacion->latitud->input->setValue($lab->Latitud);
			$this->labels->ubicacion->longitud->input->setValue($lab->Longitud);

			$this->labels->direccion->input->setValue(getTraduccion($lab->DireccionID , $_SESSION['lang']));
			$this->labels->tag->input->setValue(getTagName($lab->TagID));
			$this->labels->nombre->input->setValue(getTraduccion($lab->NombreID , $_SESSION['lang']));
			$this->labels->telefono->input->setValue($lab->Telefono);
			$this->labels->enlace->input->controller->setValueToSelect($lab->Enlace);
			$this->labels->abbr->input->controller->setValueToSelect($lab->Abbr);
			$this->labels->mail->input->setValue($lab->Mail);
			$this->labels->facebook->input->setValue($lab->Facebook);
			$this->labels->twitter->input->setValue($lab->Twitter);

			$file= '/img/logos/'.$contentIDAct.'.png';
			if(file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
			{
				$this->labels->archivo->inputFile->input->setValue($file);
			}
		}
	}
?>