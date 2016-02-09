<?php
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMInclude.php';

		class Modulo_Novedades extends DOMInclude
		{
			function renderChilds($doc , $tag)
			{
				$this->classList->add('novedades');
				
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
				start_session_if_not();

				if(isset($_SESSION['adminID']))
				{
					include_once($_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliNov.php');

					$this->appendChild
					(
						$formNov=new FormCliNov()
					);
				}

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				global $con;

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';
						
				$limit=getValFromNombreID('limit' , $this->opcGrpID , $this->opcSetsID);
				if($this->limit && is_array($limit) && $limit[0]!=='0')
				{
					$limit=$limit[0];
					$limitStr='LIMIT '.$limit;
				}
				else
				{
					$limit=$limitStr=false;
				}

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
								WHERE TagsTarget.TagID=Laboratorios.TagID
								ORDER BY Fecha DESC
							'.$limitStr
						),
						MYSQLI_ASSOC
					)
				);

				if(!isset($novedades[0]))
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

					$i=0;
					while(isset($novedades[$i]))
					{
						$novedadHTML=new DOMNovedad();
						$novAct=$novedades[$i];

						if(isset($formNov))
						{
							$novedadHTML->setCheckBox
							(
								$formNov->buildActionCheckBox($novAct['ID'])
							);
						}

						$descripcion=getTraduccion
						(
							$novAct['DescripcionID'],
							$_SESSION['lang']
						);
						

						$descTrim=trim($descripcion);

						if(!empty($descTrim))
						{
							$novedadHTML->setDescripcion
							(
								substr
								(
									convert_html_to_text
									(
										$descTrim
									),
									0,
									500
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
							'/'.
							getLangCode().
							'/espacios/'.
							getLabName().
							'/novedades/'.
							strftime
							(
								'%Y-%m-%d',
								$novedadHTML->fecha
							).
							'/'.
							urlencode
							(
								str_replace
								(
									'/',
									' ',
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

					$this->appendChild(new ClearFix());

					if($limit!==false && isset($novedades[$limit-1]))
					{
						include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMVerMas.php';

						$this->appendChild
						(
							new DOMVerMas
							(
								'/?vRecID='.$this->sID,
								gettext('Ver todas las novedades')
							)
						);
					}
				}

				return parent::renderChilds($doc , $tag);
			}
		}
?>