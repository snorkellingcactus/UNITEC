<?php
	class FormGal extends Form
	{
		public $srvBuilder;
		function __construct($srvBuilder)
		{
			parent::__construct($srvBuilder);

			$this->idSuffix=$srvBuilder->contador;

			if(isset($_POST['conID']))
			{
				$this->cantidad=count($_POST['conID']);
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrlNov.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAlt.php';
			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelPrioridad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';

			$titulo=new FormLabelTitulo($this);
			$archivo=new FormLabelUrlNov($this);
			$alt=new FormLabelAlt($this);
			$visible=new FormLabelVisible($this);

			if($srvBuilder->getAction()===0)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
				global $con;

				$imagen=fetch_all
				(
					$con->query
					(
						'	SELECT * 
							FROM Imagenes 
							WHERE TituloID='.$_POST['conID'][$srvBuilder->contador]
					),
					MYSQLI_ASSOC
				)[0];

				$archivo->inputUrl->setValue($imagen['Url']);
				$visible->selectedValue=$imagen['Visible'];
				//$this->autocomp['Prioridad']=$imagen['Prioridad'];
				$alt->input->setValue
				(
					getTraduccion
					(
						$imagen['AltID'],
						$_SESSION['lang']
					)
				);
				$titulo->input->setValue
				(
					getTraduccion
					(
						$imagen['TituloID'],
						$_SESSION['lang']
					)
				);
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';

			$continuar=new FormContinuar($this);

			$this->appendChild($titulo)
			->appendChild($alt)
			->appendChild($visible)
			->appendChild($archivo)
			->appendChild($continuar);

			if($srvBuilder->thisIsLast())
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

				$this->appendChild(new FormVolver($this));
			}
			else
			{
				$continuar->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
				$this->appendChild(new ClearFix())->appendChild(new DOMTag('hr'));
			}
		}
	}
?>