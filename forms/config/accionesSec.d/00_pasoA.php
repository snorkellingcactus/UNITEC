<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

	$selectLugar=new FormLabelLugar($this->form);
	$visible=new FormLabelVisible($this->form);
	$labelTags=new FormLabelTags($this->form);
	
	$visible->input->default=1;

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	global $con;

	if($this->getAction()===0)
	{
		$visible->input->default=intVal
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Visible
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0]
		);
	}
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

	if($this->getAction()===1)
	{
		$labelTags->input->setValue(getLabTagTree($_SESSION['lab']));
	}

	$this->form->appendChild
	(
		$selectLugar
	)->appendChild
	(
		new ClearFix()
	)->appendChild
	(
		$visible
	);

	if($_SESSION['Tipo']==='sec')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAAMenu.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAtajo.php';

		$titulo=new FormLabelTitulo($this->form);
		$aaMenu=new FormLabelAAlMenu($this->form);
		$atajo=new FormLabelAtajo($this->form);

		if($this->getAction()===0)
		{
			$htmlID=fetch_all
			(
				$con->query
				(
					'	SELECT HTMLID
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0];

			$titulo->input->setValue
			(
				html_entity_decode
				(
					$htmlID
				)
			);
			$atajoSQL=fetch_all
			(
				$con->query
				(
					'	SELECT Atajo
						FROM Menu
						WHERE SeccionID="'.$htmlID.'"'
				),
				MYSQLI_NUM
			);
/*
			echo '<pre>ID Seleccionado:';
			print_r
			(
				$selectLugar->input->selectedValue
			);
			echo '</pre>';
*/

			if(isset($atajoSQL[0]))
			{
				$atajo->input->setValue($atajoSQL[0][0]);
			}
		}

		$this->form->appendChild
		(
			$titulo
		)->appendChild
		(
			$aaMenu
		)->appendChild
		(
			$atajo
		);

		$padreIDStr='IS NULL';
	}
	else
	{

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

		$this->form->appendChild
		(
			new VariablePost($this->form , 'conID' , $_SESSION['conID'])
		);

		if($_SESSION['accion']==='nuevo')
		{
			$padreID=$_SESSION['conID'];
		}
		else
		{
			$padreID=fetch_all
			(
				$con->query
				(
					'	SELECT PadreID 
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0];
		}

		$padreIDStr='='.$padreID;
	}

	if($_SESSION['Tipo']==='con')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		$contenido=new FormLabelContenido($this->form);

		if($this->getAction()===0)
		{
			$contenido->input->setValue
			(
				getTraduccion
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT ContenidoID
								FROM Secciones
								WHERE ID='.$_SESSION['conID']
						),
						MYSQLI_NUM
					)[0][0],
					$_SESSION['lang']
				)
			);
		}

		$this->form->appendChild($contenido);
	}
	if($_SESSION['Tipo']==='inc')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelModulo.php';

		$modulos=new FormLabelModulo($this->form);

		if($this->getAction()===0)
		{
			$modulos->input->selectedValue=fetch_all
			(
				$con->query
				(
					'	SELECT Secciones.ModuloID
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0];
		}

		$modulos->setOptionsFromSQLRes
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Nombre , ID
						FROM Modulos 
						WHERE PadreID is NULL
					'
				),
				MYSQLI_NUM
			)
		);

		$this->form->appendChild
		(
			new VariablePost
			(
				$this->form,
				'conID',
				$_SESSION['conID']
			)
		)->appendChild
		(
			$modulos
		);
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';

		global $con;

		$opcGrpID=getOpcGrpModulo($_SESSION['conID']);

		if(!isset($opcGrpID[0][0]))
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';

			$this->form->appendChild
			(
				new MSGBox
				(
					gettext('No existen opciones para este módulo')
				)
			);
		}
		else
		{
			$opciones=getAllOpcGrp($opcGrpID[0][0]);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$i=0;
			while(isset($opciones[$i]))
			{
				$opcion=$opciones[$i];

				if(isset($opcGrpID[0][1]))
				{
					//echo '<pre>Exite un OpcSetsGrpID';echo '</pre>';

					$valor=getVal($opcion['ID'] , $opcGrpID[0][1]);

					if(isset($valor[0][0]))
					{
						$valor=$valor[0][0];
						//echo '<pre>Valor seteado:';print_r($valor);echo '</pre>';
					}
					else
					{
						unset($valor);
					}
				}
				if(isset($opcion['Predeterminado']))
				{
/*
					echo '<pre>Valor predeterminado:';
					print_r
					(
						$opcion['Predeterminado']
					);
					echo '</pre>';
*/
					$default=$opcion['Predeterminado'];
				}

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';

				$lBox=new LabelBox
				(
					$opcion['Nombre'],
					$opcion['Nombre'],
					getTraduccion
					(
						$opcion['Nombre'],
						$_SESSION['lang']
					)
				);

				if(isset($opcion['Min']) && isset($opcion['Max']))
				{
					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

					$min=intVal($opcion['Min']);
					$max=intVal($opcion['Max']);

					$select=new FormSelect($this->form);

					if(isset($default))
					{
						$select->default=$default;
					}
					if(isset($valor))
					{
						$select->default=$valor;
					}

					for($j=$min;$j<=$max;$j++)
					{
						$select->addOption($select->newOption($j , $j));
					}

					$lBox->setInput($select);
				}
				else
				{
					if(isset($opcion['ValGrp']))
					{
						$valids=getValids($opcion['ValGrp']);

						if(isset($valids[0][0]))
						{
							include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

							$select=new FormSelect($this->form);

							$j=0;
							while(isset($valids[$j][0]))
							{
								$valid=$valids[$j];
								if(!isset($valid[1]))
								{
									$valid[1]=$valid[0];
								}
								else
								{
									$valid[1]=getTraduccion($valid[1] , $_SESSION['lang']);
								}

								$option=$select->newOption($valid[1],$valid[0]);

								if(isset($valor))
								{
									if($valor===$valid[0])
									{
										$option->setSelected();
									}
								}
								else
								{
									if(isset($default) && $default===$valid[0])
									{
										$option->setSelected();
									}
								}

								$select->addOption
								(
									$option
								);
								++$j;
							}

							$lBox->setInput($select);
						}
					}
				}

				$this->form->appendChild($lBox);

				++$i;
			}
		}
	}

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Seccion.php';

		$selectLugar->input->selectedValue=$_SESSION['conID'];

		$grupoID=new Seccion(['ID'=>$_SESSION['conID']] , $con);
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
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

	$seccs=getPriorizados
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Secciones.HTMLID, Secciones.ID, Secciones.PrioridadesGrpID
					FROM Secciones
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID=Secciones.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE Secciones.PadreID '.$padreIDStr.'
					AND TagsTarget.TagID=Laboratorios.TagID
				'
			),
			MYSQLI_ASSOC
		)
	);
	$s=0;
	while(isset($seccs[$s]))
	{
		$seccs[$s]=array
		(
			$seccs[$s]['HTMLID'],
			$seccs[$s]['ID']
		);
		++$s;
	}
	$selectLugar->setOptionsFromSQLRes
	(
		$seccs
	);
	

	$this->form->appendChild
	(
		$labelTags
	);
	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormContinuar($this->form))
		->appendChild(new FormVolver($this->form));

		$this->form->setAction($this->getStepUrlByName('90_SQL_Evts.php'));
	}
?>