<?php
	class FormNov extends Form
	{
		public $srvBuilder;
		function __construct($srvBuilder)
		{
			parent::__construct($srvBuilder);

			$this->idSuffix=0;

			if(isset($_POST['Titulo']))
			{
				$this->cantidad=$_POST['Titulo'];
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';
			//$this->ancla='#nNov';
			/*
				[
					'selector_imagen.php',
					'Imagen'
				]
			*/

			$titulo=new FormLabelTitulo($this);
			$descripcion=new FormLabelContenido($this);
			$visible=new FormLabelVisible($this);

			if($this->srvBuilder->getAction()===0)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
				global $con;

				$novedad=fetch_all
				(
					$con->query
					(
						'	SELECT * 
							FROM Novedades 
							WHERE ID='.$this->srvBuilder->conIDAct
					),
					MYSQLI_ASSOC
				)[0];

				$visible->input->selectedValue=$novedad['Visible'];

				//$this->autocomp['Prioridad']=$novedad['Prioridad'];
				//$this->autocomp['Imagen']=$novedad['ImagenID'];
				$descripcion->input->setValue
				(
					getTraduccion
					(
						$novedad['DescripcionID'] ,
						$_SESSION['lang']
					)
				);
				$titulo->input->setValue
				(
					getTraduccion
					(
						$novedad['TituloID'] ,
						$_SESSION['lang']
					)
				);
			}
			$selectImg=new FormRadioLst($this , 'hola');
			$selectImg->addNew('mundo' );
			//$selectImg=new FormRadioLst($this , 'imagen');
			//$selectImg->add('mundo')->add('Hola');

			$this->appendChild($titulo)
			->appendChild(new ClearFix())
			->appendChild($descripcion)
			->appendChild(new ClearFix())
			->appendChild($visible)
			->appendChild(new ClearFix())
			->appendChild($selectImg)
			->appendChild(new ClearFix());
		}
	}
?>