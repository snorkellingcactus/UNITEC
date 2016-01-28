<?php
	//echo '<pre>Paso A</pre>';
	
	if(isset($_POST['conID']))
	{
		$this->cantidad=count($_POST['conID']);
	}
	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}

	//$this->form->ancla='#nEvt';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelFecha.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelDescripcion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

	$titulo=new FormLabelTitulo($this->form);
	$fecha=new FormLabelFecha($this->form);
	$descripcion=new FormLabelDescripcion($this->form);
	$visible=new FormLabelVisible($this->form);
	$prioridad=new FormLabelPrioridad($this->form);
	$labelTags=new FormLabelTags($this->form);

	$visible->input->default=1;

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

	if($this->getAction()===0)
	{
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
					WHERE DescripcionID='.$_POST['conID'][$this->contador]
			),
			MYSQLI_ASSOC
		)[0];

		$grupoID=new Evento(NULL , $con);
		$grupoID->getSQL(['DescripcionID'=>$_POST['conID'][$this->contador]]);
		$grupoID=$grupoID->getTagsGrp();

		if(isset($grupoID[0][0]))
		{
			$labelTags->input->setValue
			(
				getTagsStr($grupoID[0][0])
			);
		}
		else
		{
			echo '<pre>No group</pre>';
		}

		$visible->input->default=intVal($evento['Visible']);
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
	if($this->getAction()===1)
	{
		$labelTags->input->setValue(getLabTagTree($_SESSION['lab']));
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($descripcion)
	->appendChild($visible)
	->appendChild($fecha)
	->appendChild($prioridad)->appendChild
	(
		$labelTags
	)->appendChild($continuar)->setAction($this->getStepUrlByName('90_SQL_Evts.php'));

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