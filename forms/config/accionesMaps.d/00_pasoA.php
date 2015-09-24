<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMFragment.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImg.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImgMarker.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImgPath.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsColor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsWeight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsIcon.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsLabel.php';


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

	$jj=new GMapsImg(800 , 600 , 'AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk' , 'roadmap');
	//Revisar Url Ícono.
	$markA=new GMapsImgMarker
	(
		[
			'-34.90693',
			'-57.94290'
		],
		new GMapsColor('red'),
		new GMapsLabel('B')
	);
	$markB=new GMapsImgMarker
	(
		$origen,
		new GMapsColor('red'),
		new GMapsLabel('A')
	);
	$jj->props->add($markA)->add($markB)->add
	(
		new GMapsImgPath
		(
			[
				$markA,
				$markB
			],
			new GMapsColor('blue'),
			new GMapsWeight(7)
		)
	);
	echo '<pre>GMapsImg:';
	print_r($url=$jj->encode());
	echo '</pre>';

	echo '<pre>Original:';
	print_r
	(
		urldecode('https://maps.googleapis.com/maps/api/staticmap?&size=500x500&maptype=roadmap
				&markers=color:red%7Clabel:B%7C-34.90693 , -57.94290&markers=color:red%7Clabel:A%7C'.urlencode($origen).'&path=color:0x0000ff|weight:5|-34.90693 , -57.94290|'.urlencode($origen).'&key=AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk')
	);
	echo '</pre>';
	

	$html=new DOMDocument();

	$imgMapa=$html->createElement('img');
	$imgMapa->setAttribute
	(
		'src' , 
		$url
	);
	$imgMapa->setAttribute('class' , 'map-canvas');
	$mapa=$html->createElement('div');
	$mapa->setAttribute('class' , 'mapa col-xs-12 col-sm-6 col-md-6 col-lg-6');

	$mapa->appendChild($imgMapa);

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

	$rTabla=$html->createElement('table');
	$rTbody=$html->createElement('tbody');
	$rThead=$html->createElement('thead');

	$trThead=$html->createElement('tr');

	$thPasoN=$html->createElement('th', 'Paso Número');
	$thIns=$html->createElement('th', 'Instrucción');
	$thDist=$html->createElement('th', 'Distancia');

	$thPasoN->setAttribute('class' , 'offscreen');
	$thIns->setAttribute('class' , 'offscreen');
	$thDist->setAttribute('class' , 'offscreen');
	$rTabla->setAttribute('summary' , 'Indicaciones de cómo llegar');

	$trThead->appendChild($thPasoN);
	$trThead->appendChild($thIns);
	$trThead->appendChild($thDist);

	$rutas->appendChild($startDiv);
	$rutas->appendChild($html->createTextNode('Distancia:'.$distancia.', Aproximadamente '.$duracion));

	$iMax=$pasos->length;
	for($i=0;$i<$iMax;$i++)
	{
		$paso=$pasos->item($i);

		$distancia=$paso->getElementsByTagName('distance')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;

		$instruccion=$paso->getElementsByTagName('html_instructions')->item(0)->nodeValue;

		$fragment=$html->createDocumentFragment();
		$fragment->appendXML($instruccion);

		$tr=$html->createElement('tr');
		$tr->setAttribute('scope','col');
		$numero=$html->createElement('td' , $i+1);
		$instruccion=$html->createElement('td');

		$instruccion->appendChild($fragment);
		$tr->appendChild($numero);
		$tr->appendChild($instruccion);
		$tr->appendChild($html->createElement('td',$distancia));

		$maniobra=$paso->getElementsByTagName('maneuver');

		if($maniobra->length===1)
		{
			$instruccion->setAttribute('class',$maniobra->item(0)->nodeValue);
		}

		$rTbody->appendChild($tr);

		//$html=$html.$leg->item($i)->nodeValue."\n";
		//$html=$html.'Modo:'.$travelModes->item($i)->nodeValue."\n";
	}

	$rThead->appendChild($trThead);
	$rTabla->appendChild($rThead);
	$rTabla->appendChild($rTbody);

	$rutas->appendChild($rTabla);
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


/*
	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';
		$volver=new FormVolver($this->form);
		$volver->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

		$this->form->setAction($this->getNextStepUrl());
	}
*/
?>