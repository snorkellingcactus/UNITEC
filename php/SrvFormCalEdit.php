<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormCalEdit extends SrvStepRepeatedForm
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Editar Evento ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCalBase.php';
			
			return new LabelsCalBase($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Evento.php';

			global $con;

			$evento=fetch_all
			(
				$con->query
				(
					'	SELECT * 
						FROM Eventos 
						WHERE DescripcionID='.$this->labels->getContentID()
				),
				MYSQLI_ASSOC
			)[0];

			$grupoID=new Evento(NULL , $con);
			$grupoID->getSQL
			(
				[
					'DescripcionID'=>$this->labels->getContentID()
				]
			);
			$grupoID=$grupoID->getTagsGrp();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			if(isset($grupoID[0][0]))
			{
				$this->labels->labelTags->input->setValue
				(
					getTagsStr($grupoID[0][0])
				);
			}
			else
			{
				echo '<pre>No group</pre>';
			}
			
			$this->labels->visible->input->controller->setValueToSelect($evento['Visible']);
			$this->labels->prioridad->input->setValue($evento['Prioridad']);

			$this->labels->titulo->input->setValue
			(
				getTraduccion
				(
					$evento['NombreID'],
					$_SESSION['lang']
				)
			);
	/*
			echo '<pre>Fecha consultada:';
			print_r($evento['Tiempo']);
			echo '</pre>';
	*/
			$fechaEvento=new DateTime($evento['Tiempo']);

			$this->labels->fecha->inputAno->input->setValue($fechaEvento->format('Y'));
			$this->labels->fecha->inputMes->input->setValue($fechaEvento->format('m'));
			$this->labels->fecha->inputDia->input->setValue($fechaEvento->format('d'));
			$this->labels->fecha->inputHora->input->setValue($fechaEvento->format('H'));
			$this->labels->fecha->inputMin->input->setValue($fechaEvento->format('i'));

			//$this->form->autocomp['Fecha']=$evento['Tiempo'];
			$this->labels->descripcion->input->setValue
			(
				getTraduccion
				(
					$evento['DescripcionID'],
					$_SESSION['lang']
				)
			);
		}
	}
?>