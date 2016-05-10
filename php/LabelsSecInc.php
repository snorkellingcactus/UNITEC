<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecOther.php';

	class LabelsSecInc extends LabelsSecOther
	{
		public $modulos;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelModulo.php';

			$this->appendChild
			(
				$this->modulos=new FormLabelModulo()
			);

			$this->modulos->setOptionsFromSQLRes
			(
				fetch_all
				(
					$this->con->query
					(
						'	SELECT Nombre , ID
							FROM Modulos 
							WHERE PadreID is NULL
						'
					),
					MYSQLI_NUM
				)
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/opciones.php';

			$opcGrpID=getOpcGrpModulo($this->getContentID());

			if(!isset($opcGrpID[0][0]))
			{
	/*
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';

				$this->appendChild
				(
					new MSGBox
					(
						gettext('No existen opciones para este módulo')
					)
				);
	*/
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
						echo '<pre>Exite un OpcSetsGrpID';echo '</pre>';

						$valor=getVal($opcion['ID'] , $opcGrpID[0][1]);

						if(isset($valor[0][0]))
						{
							$valor=$valor[0][0];
							echo '<pre>Valor seteado:';print_r($valor);echo '</pre>';
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

						$select=new FormSelect();

						if(isset($default))
						{
							$select->controller->setValueToSelect($default);
						}
						if(isset($valor))
						{
							$select->controller->setValueToSelect($valor);
						}

						for($j=$min;$j<=$max;$j++)
						{
							$select->controller->addOption
							(
								$select->controller->newOption($j , $j)
							);
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

								$select=new FormSelect();

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

									$option=$select->controller->newOption($valid[1],$valid[0]);

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

					$this->appendChild($lBox);

					++$i;
				}
			}
		}
	}
?>