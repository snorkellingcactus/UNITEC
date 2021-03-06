<?php
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMInclude.php';

		class Modulo_Novedades extends DOMInclude
		{
			function calcLimit()
			{
				parent::calcLimit();

				return $this;
			}
			function renderChilds( &$tag )
			{
				$this->addToAttribute('class' , 'novedades');

				$this->setAdminFormName( 'FormCliNov' );

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				global $con;

				$novedades=getPriorizados
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT Novedades.* FROM `Novedades`
								LEFT OUTER JOIN TagsTarget
								ON TagsTarget.GrupoID=Novedades.TagsGrpID
								LEFT OUTER JOIN Laboratorios
								ON Laboratorios.ID='.$_SESSION['lab'].'
								WHERE TagsTarget.TagID=Laboratorios.TagID'.
								$this->getFilterVisible().
								' ORDER BY Fecha DESC'.$this->getFilterLimit()
						),
						MYSQLI_ASSOC
					)
				);

				if( !isset($novedades[0] ) )
				{
					$this->appendChild
					(
						new DOMTag('p' , gettext('Sin novedades'))
					);
				}
				else
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/html2text/html2text.php';
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMNovedad.php';

					$form=$this->getAdminForm();

					$i=0;
					while( isset( $novedades[$i] ) )
					{
						$novedadHTML=new DOMNovedad();
						$novAct=$novedades[$i];

						if( $form !== false )
						{
							$novedadHTML->setCheckBox
							(
								$form->buildActionCheckBox( $novAct['ID'] )
							);
						}

						$descripcion=getTraduccion
						(
							$novAct['DescripcionID'],
							$_SESSION['lang']
						);
						

						$descTrim=trim( $descripcion );

						if( !empty( $descTrim ) )
						{
							$novedadHTML->setDescripcion
							(
								mb_substr //http://stackoverflow.com/a/15138120
								(
									convert_html_to_text
									(
										$descTrim
									),
									0,
									500,
									'utf-8'
								)
							);
						}
						

						//Revisar.A futuro guardar en la db una version en texto plano.
						$novedadHTML->setTitulo
						(
							getTraduccion
							(
								$novAct['TituloID'],
								$_SESSION['lang']
							)
						)->setFechaFromYmdHis
						(
							$novAct['Fecha']
						)->setImgSrc
						(
							'/img/miniaturas/galeria/'.$novAct['ImagenID'].'.png'
						)->setImgAlt
						(
							getTraduccion
							(
								fetch_all
								(
									$con->query
									(
										'	SELECT AltID
											FROM Imagenes
											WHERE ID='.$novAct['ImagenID']
									),
									MYSQLI_NUM
								)[0][0],
								$_SESSION['lang']
							)
						)->setFullUrl
						(
							//Revisar . Código en común con VisorImagenes, DOMMenuOpc, Modulo_Novedades , Modulo_Imagenes
							getLabUrl(getLabName()).
							'/novedades/'.
							strftime
							(
								'%Y-%m-%d',
								$novedadHTML->fecha
							).
							'/'.
							str_replace
							(
								['%2F' , '%3F' , '%2C'],
								'',
								urlencode
								(
									$novedadHTML->titulo
										
								)
							).
							'-'.
							$novAct['ID']
						);

						if
						(
							isset($formNovRecv->afectados) &&
							in_array($novAct['TituloID'] , $formNovRecv->afectados)
						)
						{
							$novedadHTML->afectado=true;
						}
						else
						{
							$novedadHTML->afectado=false;
						}

						$this->appendChild
						(
							$novedadHTML
						);

						++$i;
					}

					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

					$this->appendChild( new ClearFix() );

					$limit=$this->getLimit();

					if( $limit!==false && isset( $novedades[$limit-1] ) )
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMVerMas.php';

						$this->appendChild
						(
							new DOMVerMas
							(
								'/?vRecID='.$this->sID ,
								gettext('Ver todas las novedades')
							)
						);
					}
				}

				return parent::renderChilds( $tag );
			}
		}
?>