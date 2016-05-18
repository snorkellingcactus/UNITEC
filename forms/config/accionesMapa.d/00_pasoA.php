<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$action=FormActions::checkActionIn( $_POST );

			if($action===false)
			{
				$action=FormActions::checkActionIn( $_SESSION );
			}

			$_SESSION['ACTION'.$action]=true;
			
			if
			(
				FormActions::isFlagSet
				(
					$action,
					FormActions::FORM_ACTIONS_NEW
				)
			)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMFragment.php';

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImg.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImgMarker.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsImgPath.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsColor.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsWeight.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsIcon.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/GMapsLabel.php';

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

				$session=new FormSession();
				$session->loadLabels( 'ModoViaje' , 'Origen' );
				$session->save();

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

				$origen=$session->getLabel('Origen');

				$modo=strtolower
				(
					$session->getLabel( 'ModoViaje' )
				);


	/*
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
	*/
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
				$lab=getLabPos( $_SESSION['lab'] ) ;
				
				if( $lab === false )
				{
					$status=false;

					if( isset( $_SESSION['adminID'] ) )
					{
						$msg=gettext
						(
							'
								Parece ser que no se han indicado las posiciones de este laboratorio o alguno de
								sus laboratorios padre. Por favor edite los laboratorios especificando una
								Latitud y una Longitud. '
						);
					}
					else
					{
						$msg=gettext
						(
							' Lo sentimos. Surgió un problema interno y no podemos brindarte lo que buscabas. '
						);
					}
				}
				else
				{
					$labLat=$lab[0];
					$labLng=$lab[1];

					$xml=new DOMDocument();
					$xml->loadXML
					(
						$jj=file_get_contents
						(
							'https://maps.googleapis.com/maps/api/directions/xml?origin='.
							urlencode($origen).
							'&destination='.
							urlencode( $labLat.' , '.$labLng ).
							'&language='.
							urlencode($langName).
							'&mode='.
							urlencode($modo).
							'&key=AIzaSyBYdVjZ_Ox7egY1pCBo1Cr_PFOZsvfb5n4'
						)
					);

	//				echo '<pre>';print_r(htmlentities($xml->saveXML()));echo '</pre>';

					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormOtroOrigen.php';

					$status=$xml->getElementsByTagName( 'status' )->item(0)->nodeValue;
				}

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormBase.php';

				$form=new FormBase();

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUForms.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

				$mainHTML=new HTMLUForms();
				$mainHTML->appendChild
				(
					$body=new DOMBody()
				);

				if( $status === 'ZERO_RESULTS' )
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

					$msg=sprintf
					(
						gettext
						(
							'
								Lo sentimos. No pudimos establecer una ruta entre el origen especificado ( "%s" ) y %s.
								Intente con un origen distinto.
							'
						) ,
						$origen ,
						getLabName()
					);
				}
				if( $status ===  'REQUEST_DENIED')
				{
					$msg=gettext
					(
						'Lo sentimos. En este momento estamos experimentando problemas con el servicio de mapas de Google.'
					);
				}

				if( isset( $msg ) )
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

					$mainHTML->appendChild
					(
						$form->addToAttribute
						(
							'class' ,
							'Form tresem'
						)->appendChild
						(
							new ClearFix()
						)->appendChild
						(
							new MSGBox( $msg )
						)
					);
				}

				if( ( $status === 'ZERO_RESULTS' ) || !isset( $msg ) )
				{
					$form->setAction
					(
						$this->getRouter()->getStepUrlByName
						(
							'10_Select_Origin.php'
						)
					)->appendChild
					(
						$otroOrigen=new FormOtroOrigen()
					);

					$otroOrigen->col=['xs' => 6 , 'sm' => 6 , 'md' => 6 , 'lg' => 6];
					$otroOrigen->addToAttribute( 'class' , 'GMapsFormSubmit' );
				}

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';
				$form->appendChild
				(
					$volver=new FormVolver()
				);

				$volver->addToAttribute( 'class' , 'GMapsFormSubmit' );



				if( !isset( $msg ) )
				{
					$html=new DOMDocument('1.0' , 'UTF-8');

					$startIcon=$html->createElement('img');
					$startIcon->setAttribute
					(
						'src' ,
						'https://mts.googleapis.com/maps/vt/icon/name=icons/spotlight/spotlight-waypoint-a.png&text=A&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1'
					); //Igual al del footer.js para apariencia uniforme.
					$startIcon->setAttribute('alt' , htmlentities(gettext('Origen')));

					$endIcon=$html->createElement('img');
					$endIcon->setAttribute
					(
						'src' ,
						'https://mts.googleapis.com/maps/vt/icon/name=icons/spotlight/spotlight-waypoint-b.png&text=B&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1'
					); //Igual al del footer.js para apariencia uniforme.
					$endIcon->setAttribute('alt' , htmlentities(gettext('Destino')));

					$urlMapa=new GMapsImg
					(
						800 ,
						600 ,
						'AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk' ,
						'roadmap'
					);

					//Revisar Url Ícono.
					$markA=new GMapsImgMarker
					(
						[
							$labLat,
							$labLng
						],
		/*
						new GMapsIcon
						(
							'http://'.$_SERVER['SERVER_ADDR'].
							$startIcon->getAttribute( 'src' )
						),
		*/
						new GMapsColor( 'red' ),
						new GMapsLabel( gettext('B') )
					);

					$location=$xml
					->getElementsByTagName( 'leg' )->item(0)
					->getElementsByTagName( 'start_location' )->item(0);

					$markB=new GMapsImgMarker
					(
						[
							$location->getElementsByTagName( 'lat' )->item(0)->nodeValue,
							$location->getElementsByTagName( 'lng' )->item(0)->nodeValue
						],
		/*
						new GMapsIcon
						(
							'http://'.$_SERVER['SERVER_ADDR'].
							$endIcon->getAttribute( 'src' )
						),
		*/
						new GMapsColor( 'green' ),
						new GMapsLabel( gettext('A') )
					);
					
					$enc=new GMapsObj('enc' , ':' , new GMapsProps('|') );

					$enc->add
					(
						$xml->getElementsByTagName
						(
							'overview_polyline'
						)->item(0)->getElementsByTagName
						(
							'points'
						)->item(0)->nodeValue
					);

					$urlMapa->props->add($markA)->add($markB)->add
					(
						new GMapsImgPath
						(
							new GMapsColor	('blue'),
							new GMapsWeight	(2),
							/*
							$markA->coords,
							$markB->coords
							*/
							$enc
						)
					);

					$imgMapa=$html->createElement('img');
					$imgMapa->setAttribute
					(
						'src' , 
						$urlMapa->encode()
					);

					$imgMapa->setAttribute('class' , 'map-canvas');

					$mapa=$html->createElement('div');
					$mapa->setAttribute('class' , 'mapa col-xs-12 col-sm-6 col-md-6 col-lg-6');

					$mapa->appendChild($imgMapa);

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

					$endDiv=$html->createElement('span');
					

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

					$thPasoN=$html->createElement('th', htmlentities(gettext('Paso Número')));
					$thIns=$html->createElement('th', htmlentities(gettext('Instrucción')));
					$thDist=$html->createElement('th', htmlentities(gettext('Distancia')));

					$thPasoN->setAttribute('class' , 'offscreen');
					$thIns->setAttribute('class' , 'offscreen');
					$thDist->setAttribute('class' , 'offscreen');
					//Revisar.
					//$rTabla->setAttribute('summary' , htmlentities(gettext('Indicaciones de cómo llegar')));

					$trThead->appendChild($thPasoN);
					$trThead->appendChild($thIns);
					$trThead->appendChild($thDist);

					$rutas->appendChild($startDiv);
					$rutas->appendChild
					(
						$html->createTextNode
						(
							sprintf
							(
								gettext
								(
									'Distancia: %1$s , Aproximadamente: %2$s'
								),
								$distancia,
								$duracion
							)
						)
					);

					$iMax=$pasos->length;
					for($i=0;$i<$iMax;$i++)
					{
						$paso=$pasos->item($i);

						$distancia=$paso->getElementsByTagName('distance')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;

						$instruccion=
						
							$paso->getElementsByTagName('html_instructions')->item(0)->nodeValue
						;

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
							$instruccion->setAttribute
							(
								'class' ,
								$maniobra->item(0)->nodeValue
							);
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

					$form->addToAttribute
					(
						'class' ,
						'GMapsForm'
					)->renderChilds
					(
						new DOMInitialTag()
					);

					$contenedor->appendChild
					(
						$html->importNode($form->tag , 1)
					);
					$contenedor->appendChild($rutasCont);
					$contenedor->appendChild($clearFix);

					$body->appendChild
					(
						new DOMFragment
						(
							utf8_decode
							(
								$html->saveHTML($contenedor)
							)
							
						)
					);
				}

				echo $mainHTML->getHTML();
			}
		}
	}

?>