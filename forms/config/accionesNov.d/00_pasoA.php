<?php
	//echo '<pre>Paso A</pre>';
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelImagen.php';
	//$this->form->ancla='#nNov';
	/*
		[
			'selector_imagen.php',
			'Imagen'
		]
	*/

	$titulo=new FormLabelTitulo($this->form);
	$descripcion=new FormLabelContenido($this->form);
	$visible=new FormLabelVisible($this->form);
	$selectImg=new FormLabelImagen($this->form , 'Imagen' , 'imagen' , 'Imagen');

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	global $con;

	if($this->form->srvBuilder->getAction()===0)
	{
		$novedad=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Novedades 
					WHERE ID='.$this->form->srvBuilder->conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$visible->input->selectedValue=$novedad['Visible'];

		//$this->form->autocomp['Prioridad']=$novedad['Prioridad'];
		//$this->form->autocomp['Imagen']=$novedad['ImagenID'];
		$descripcion->input->setValue
		(
			getTraduccion
			(
				$novedad['DescripcionID'] ,
				$_SESSION['lang']
			)
		);
		$titulo->input->setValue
		(
			getTraduccion
			(
				$novedad['TituloID'] ,
				$_SESSION['lang']
			)
		);

		$selectImg->input->selectedValue=$novedad['ImagenID'];
	}

	$Imgs=fetch_all
	(
		$con->query
		(
			'	SELECT Imagenes.ID,Imagenes.AltID
				FROM Imagenes
				WHERE 1
				ORDER BY Prioridad
			'
		),
		MYSQLI_NUM
	);

	$i=0;
	while(isset($Imgs[$i]))
	{
		$imgId=$Imgs[$i][0];

		$selectImg->input->addNew
		(
			$imgId,
			'/img/miniaturas/galeria/'.$imgId.'.png',
			getTraduccion($Imgs[$i][1] , $_SESSION['lang'])
		);

		++$i;
	}
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

	$continuar=new FormContinuar($this->form);

	$this->form->appendChild($titulo)
	->appendChild($descripcion)
	->appendChild($visible)
	->appendChild($selectImg)
	->clearFix()
	->appendChild($continuar)
	->setAction($this->getNextStepUrl());

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