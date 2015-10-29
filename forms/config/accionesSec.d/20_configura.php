<?php
	if($_SESSION['Tipo']==='inc')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
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
					echo '<pre>Exite un OpcSetsGrpID';
					echo '</pre>';

					$valor=getVal($opcion['ID'] , $opcGrpID[0][1]);

					if(isset($valor[0][0]))
					{
						$valor=$valor[0][0];
						echo '<pre>Valor seteado:';
						print_r
						(
							$valor
						);
						echo '</pre>';
					}
					else
					{
						unset($valor);
					}
				}
				if(isset($opcion['Predeterminado']))
				{
					echo '<pre>Valor predeterminado:';
					print_r
					(
						$opcion['Predeterminado']
					);
					echo '</pre>';

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
	else
	{

	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

	$this->form->appendChild
	(
		new FormContinuar($this->form)
	)->appendChild
	(
		new FormVolver($this->form)
	);

	$this->form->setAction($this->getOriginUrl());
?>