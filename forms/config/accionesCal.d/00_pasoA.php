<?php
	//echo '<pre>Paso A</pre>';
	
	if(isset($_POST['conID']))
	{
		$this->cantidad=count($_POST['conID']);
	}

	//$this->form->ancla='#nEvt';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelFecha.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelDescripcion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';

	$titulo=new FormLabelTitulo($this->form);
	$fecha=new FormLabelFecha($this->form);
	$descripcion=new FormLabelDescripcion($this->form);
	$visible=new FormLabelVisible($this->form);
	$prioridad=new FormLabelPrioridad($this->form);

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		$evento=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Eventos 
					WHERE DescripcionID='.$_POST['conID'][$this->contador]
			),
			MYSQLI_ASSOC
		)[0];

		$visible->selectedValue=$evento['Visible'];
		$prioridad->input->setValue($evento['Prioridad']);
		$titulo->input->setValue
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

		$fecha->inputAno->input->setValue($fechaEvento->format('Y'));
		$fecha->inputMes->input->setValue($fechaEvento->format('m'));
		$fecha->inputDia->input->setValue($fechaEvento->format('d'));
		$fecha->inputHora->input->setValue($fechaEvento->format('H'));
		$fecha->inputMin->input->setValue($fechaEvento->format('i'));

		//$this->form->autocomp['Fecha']=$evento['Tiempo'];
		$descripcion->input->setValue
		(
			getTraduccion
			(
				$evento['DescripcionID'],
				$_SESSION['lang']
			)
		);

		//echo '<pre>Evento:';print_r($evento);echo '</pre>';
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($descripcion)
	->appendChild($visible)
	->appendChild($fecha)
	->appendChild($prioridad)
	->appendChild($continuar)->setAction($this->getNextStepUrl());

	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormVolver($this->form));
	}
	else
	{
		$continuar->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
		$this->form->appendChild(new ClearFix())->appendChild(new DOMTag('hr'));
	}
?>