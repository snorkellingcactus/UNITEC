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

	$html=new DOMDocument();

	$mapa=$html->createElement('img');
	$mapa->setAttribute
	(
		'src' , 
		'https://maps.googleapis.com/maps/api/staticmap?&size=500x500&maptype=roadmap
		&markers=color:red%7Clabel:B%7C-34.90693 , -57.94290&markers=color:red%7Clabel:A%7C'.urlencode($origen).'&path=color:0x0000ff|weight:5|-34.90693 , -57.94290|'.urlencode($origen).'&key=AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk'
	);
	$mapa->setAttribute('class' , 'mapa col-xs-12 col-sm-6 col-md-6 col-lg-6');

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

	$startAddr=$xml->getElementsByTagName('start_address')->item(0);
	$endAddr=$xml->getElementsByTagName('end_address')->item(0);
	$copy=$xml->getElementsByTagName('copyrights')->item(0);

	$distancia=$xml->getElementsByTagName('distance')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;
	$duracion=$xml->getElementsByTagName('duration')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;

	$rutasCont=$html->createElement('div');
	$rutasCont->setAttribute('class' , 'rutas col-xs-12 col-sm-6 col-md-6 col-lg-6');

	$rutas=$html->createElement('div');

	$startDiv=$html->createElement('span');
	$startIcon=$html->createElement('img');
	$startIcon->setAttribute('src' , '/img/marcadorA.png');
	$startIcon->setAttribute('alt' , 'Origen');

	$endDiv=$html->createElement('span');
	$endIcon=$html->createElement('img');
	$endIcon->setAttribute('src' , '/img/marcadorB.png');
	$endIcon->setAttribute('alt' , 'Destino');

	$startDiv->setAttribute('class' , 'start-address');
	$endDiv->setAttribute('class' , 'end-address');

	$startDiv->appendChild($startIcon);
	$startDiv->appendChild($html->createTextNode($startAddr->nodeValue));
	$endDiv->appendChild($endIcon);
	$endDiv->appendChild($html->createTextNode($endAddr->nodeValue));

	$ol=$html->createElement('ol');

	$rutas->appendChild($startDiv);
	$rutas->appendChild($html->createTextNode($distancia.', Aproximadamente '.$duracion));

	$iMax=$pasos->length;
	for($i=0;$i<$iMax;$i++)
	{
		$paso=$pasos->item($i);

		$distancia=$paso->getElementsByTagName('distance')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;

		$instruccion=$paso->getElementsByTagName('html_instructions')->item(0)->nodeValue;

		$fragment=$html->createDocumentFragment();
		$fragment->appendXML($instruccion);

		$li=$html->createElement('li');
		$instruccion=$html->createElement('span');
		$instruccion->setAttribute('class','instruccion');

		$instruccion->appendChild($fragment);
		$li->appendChild($instruccion);
		$li->appendChild($html->createElement('span',$distancia));

		$maniobra=$paso->getElementsByTagName('maneuver');

		if($maniobra->length===1)
		{
			$li->setAttribute('class',$maniobra->item(0)->nodeValue);
		}

		$ol->appendChild($li);

		//$html=$html.$leg->item($i)->nodeValue."\n";
		//$html=$html.'Modo:'.$travelModes->item($i)->nodeValue."\n";
	}

	$rutas->appendChild($ol);
	$rutas->appendChild($endDiv);

	$rutas->appendChild
	(
		$html->createElement('small' , $copy->nodeValue)
	);
	$rutasCont->appendChild($rutas);

	$clearFix=$html->createElement('div');
	$clearFix->setAttribute('class','clearfix');

	$contenedor=$html->createElement('div');
	$contenedor->setAttribute('class' , 'gmaps');
	$contenedor->appendChild($mapa);
	$contenedor->appendChild($rutasCont);
	$contenedor->appendChild($clearFix);

	echo $html->saveHTML($contenedor);
/*
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
		htmlentities
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
		)
	);
	echo '</pre>';

*/



	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';
		$volver=new FormVolver($this->form);
		$volver->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

		$this->form->setAction($this->getNextStepUrl());
	}
?>