<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

	global $con;

	$langName=fetch_all
	(
		$con->query
		(
			'SELECT Pais
			FROM Lenguajes
			WHERE ID='.$_SESSION['lang']
		),
		MYSQLI_NUM
	)[0][0];

	$origen=$_POST['origen'];
	$modo=strtolower($_POST['modo_viaje']);

	$xml=DOMDocument::loadXML
	(
		file_get_contents
		(
			'https://maps.googleapis.com/maps/api/directions/xml?origin='.
			urlencode($origen).
			'&destination='.
			urlencode('-34.90693 , -57.94290').
			'&language='.
			urlencode($langName).
			'&mode='.
			urlencode($modo).
			'&key=AIzaSyBYdVjZ_Ox7egY1pCBo1Cr_PFOZsvfb5n4'
		)
	);

	$pasos=$xml->getElementsByTagName('step');
	$html=new DOMDocument();

	$ol=$html->createElement('ol');

	$iMax=$pasos->length;
	for($i=0;$i<$iMax;$i++)
	{
		$paso=$pasos->item($i);


		$instruccion=$paso->getElementsByTagName('html_instructions')->item(0)->nodeValue;

		$fragment=$html->createDocumentFragment();
		$fragment->appendXML($instruccion);

		$li=$html->createElement('li');
		$li->appendChild($fragment);

		$maniobra=$paso->getElementsByTagName('maneuver');

		if($maniobra->length===1)
		{
			$li->setAttribute('class',$maniobra->item(0)->nodeValue);
		}

		$ol->appendChild($li);

		//$html=$html.$leg->item($i)->nodeValue."\n";
		//$html=$html.'Modo:'.$travelModes->item($i)->nodeValue."\n";
	}

	echo $html->saveHTML($ol);

	echo '<pre> Url:';
	print_r
	(
		'https://maps.googleapis.com/maps/api/directions/xml?origin='.
			urlencode($origen).
			'&destination='.
			urlencode('-34.90693 , -57.94290').
			'&language='.
			urlencode($langName).
			'&mode='.
			urlencode($modo).
			'&key=AIzaSyBYdVjZ_Ox7egY1pCBo1Cr_PFOZsvfb5n4'
	);
	echo '</pre>';

	echo '<pre> Respuesta:';
	print_r
	(
		file_get_contents
		(
			'https://maps.googleapis.com/maps/api/directions/xml?origin='.
			urlencode($origen).
			'&destination='.
			urlencode('-34.90693 , -57.94290').
			'&language='.
			urlencode($langName).
			'&mode='.
			urlencode($modo).
			'&key=AIzaSyBYdVjZ_Ox7egY1pCBo1Cr_PFOZsvfb5n4'
		)
	);
	echo '</pre>';


/*
	$mapa=new DOMTag('img');
	$mapa->setAttribute
	(
		'src' , 
		'https://maps.googleapis.com/maps/api/staticmap?&size=500x500&maptype=roadmap
		&markers=color:red%7Clabel:B%7C-34.90693 , -57.94290&markers=color:red%7Clabel:A%7C'.urlencode($origen).'&path=color:0x0000ff|weight:5|-34.90693 , -57.94290|'.urlencode($origen).'&key=AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk'
	);
	
	$this->form->appendChild
	(
		$mapa
	);
*/	


	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';
		$volver=new FormVolver($this->form);
		$volver->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

		$this->form->setAction($this->getNextStepUrl());
	}
?>