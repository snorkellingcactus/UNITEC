<?php
	class FormCal extends Form
	{
		public $srvBuilder;
		function __construct($srvBuilder)
		{
			parent::__construct($srvBuilder);

			$this->idSuffix=0;

			if(isset($_POST['conID']))
			{
				$srvBuilder->cantidad=count($_POST['conID']);
			}

			//$this->ancla='#nEvt';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelFecha.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelDescripcion.php';

			$titulo=new FormLabelTitulo($this);
			$fecha=new FormLabelFecha($this);
			$descripcion=new FormLabelDescripcion($this);
			$visible=new FormLabelVisible($this);

			if($srvBuilder->getAction()===0)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

				$evento=fetch_all
				(
					$con->query
					(
						'	SELECT * 
							FROM Eventos 
							WHERE DescripcionID='.$_POST['conID'][$srvBuilder->contador]
					),
					MYSQLI_ASSOC
				)[0];

				$visible->selectedValue=$evento['Visible'];
				//$this->autocomp['Prioridad']=$evento['Prioridad'];
				$titulo->input->setValue
				(
					getTraduccion
					(
						$evento['NombreID'],
						$_SESSION['lang']
					)
				);
				echo '<pre>Fecha consultada:';
				print_r($evento['Tiempo']);
				echo '</pre>';

				$fechaEvento=new DateTime($evento['Tiempo']);

				$fecha->inputAno->input->setValue($fechaEvento->format('Y'));
				$fecha->inputMes->input->setValue($fechaEvento->format('m'));
				$fecha->inputDia->input->setValue($fechaEvento->format('d'));
				$fecha->inputHora->input->setValue($fechaEvento->format('H'));
				$fecha->inputMin->input->setValue($fechaEvento->format('i'));

				//$this->autocomp['Fecha']=$evento['Tiempo'];
				$descripcion->input->setValue
				(
					getTraduccion
					(
						$evento['DescripcionID'],
						$_SESSION['lang']
					)
				);

				//echo '<pre>Evento:';print_r($evento);echo '</pre>';
			}

			$this->appendChild($titulo)
			->appendChild(new ClearFix())
			->appendChild($descripcion)
			->appendChild(new ClearFix())
			->appendChild($visible)
			->appendChild(new ClearFix())
			->appendChild($fecha);
			//$prioridad
		}
	}
?>