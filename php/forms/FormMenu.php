<?php
	class FormMenu extends Form
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

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrl.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';

			$titulo=new FormLabelTitulo($this);
			$url=new FormLabelUrl($this);
			$lugar=new FormLabelLugar($this);
			$visible=new FormLabelVisible($this);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			global $con;

			if($srvBuilder->getAction()===0)
			{

				$opcion=fetch_all
				(
					$con->query
					(
						'	SELECT *
							FROM Menu
							WHERE ContenidoID='.$_POST['conID']
					),
					MYSQLI_ASSOC
				)[0];

				$url->input->setValue($opcion['Url']);
				$visible->input->selectedValue=$opcion['Visible'];
				//$this->autocomp['Prioridad']=$opcion['Prioridad'];
				$titulo->input->setValue
				(
					getTraduccion
					(
						$opcion['ContenidoID'],
						$_SESSION['lang']
					)
				);

				$lugar->input->selectedValue=$_POST['conID'];
			}

			$lleno=fetch_all
			(
				$con->query
				(
					'	SELECT ContenidoID,ContenidoID
						FROM Menu
						WHERE 1
						ORDER BY Prioridad ASC
					'
				),
				MYSQLI_NUM
			);

			$iMax=count($lleno);
			for($i=0;$i<$iMax;$i++)
			{
				$lleno[$i][0]=getTraduccion($lleno[$i][0] , $_SESSION['lang']);
			}

			$lugar->setOptionsFromSQLRes
			(
				$lleno
			);

			$this->appendChild($titulo)
			->appendChild(new ClearFix())
			->appendChild($url)
			->appendChild(new ClearFix)
			->appendChild($lugar)
			->appendChild(new ClearFix())
			->appendChild($visible);

			if($srvBuilder->thisIsLast())
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

				$this->appendChild(new FormContinuar($this))
				->appendChild(new FormVolver($this));

				$this->setAction($srvBuilder->getNextStepUrl());
			}
		}
	}
?>