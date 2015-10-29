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
			$opciones=getOpcGrp($opcGrpID[0][0]);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$i=0;
			while(isset($opciones[$i]))
			{
				$opcion=$opciones[$i];

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

					if(isset($opcion['Predeterminado']))
					{
						echo '<pre>Se aplica el valor predeterminado:';
						print_r
						(
							$opcion['Predeterminado']
						);
						echo '</pre>';

						$select->default=$opcion['Predeterminado'];
					}
					if(isset($opcGrpID[0][1]))
					{
						echo '<pre>Exite un OpcSetsGrpID';
						echo '</pre>';

						$valor=getVal($opcion['ID'] , $opcGrpID[0][1]);

						if(isset($valor[0][0]))
						{
							echo '<pre>Se obtuvo un valor seteado:';
							print_r
							(
								$valor[0][0]
							);
							echo '</pre>';
							$select->default=$valor[0][0];
						}
					}

					for($j=$min;$j<=$max;$j++)
					{
						$select->addOption($select->newOption($j , $j));
					}

					$lBox->setInput($select);
				}
				else
				{
					
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