<?php
	class FormSec extends Form
	{
		public $srvBuilder;
		function __construct($srvBuilder)
		{
			parent::__construct($srvBuilder);

			$this->idSuffix=0;

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';

			$selectLugar=new FormLabelLugar($this);
			$visible=new FormLabelVisible($this);


			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			if($this->srvBuilder->getAction()===0)
			{
				$visible->input->default=intVal
				(
					fetch_all
					(
						$con->query
						(
							'	SELECT Visible
								FROM Secciones
								WHERE ID='.$_POST['conID']
						),
						MYSQLI_NUM
					)[0][0]
				);
			}

			$this->appendChild
			(
				$selectLugar
			)->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				$visible
			);

			if($_POST['Tipo']==='sec')
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAAMenu.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAtajo.php';

				$titulo=new FormLabelTitulo($this);
				$aaMenu=new FormLabelAAlMenu($this);
				$atajo=new FormLabelAtajo($this);

				if($this->srvBuilder->getAction()===0)
				{
					$titulo->input->setValue
					(
						html_entity_decode
						(
							fetch_all
							(
								$con->query
								(
									'	SELECT HTMLID
										FROM Secciones
										WHERE ID='.$_POST['conID']
								),
								MYSQLI_NUM
							)[0][0]
						)
					);
					$atajoSQL=fetch_all
					(
						$con->query
						(
							'	SELECT Atajo
								FROM Menu
								WHERE SeccionID="'.$_POST['conID'].'"'
						),
						MYSQLI_NUM
					);

					if(isset($atajoSQL[0]))
					{
						$atajo->setValue($atajoSQL[0]);
					}
				}

				$this->appendChild
				(
					new ClearFix()
				)->appendChild
				(
					$titulo
				)->appendChild
				(
					new ClearFix()
				)->appendChild
				(
					$aaMenu
				)->appendChild
				(
					new ClearFix()
				)->appendChild
				(
					$atajo
				);

				$padreIDStr='IS NULL';
			}
			else
			{

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	
				$this->appendChild
				(
					new VariablePost('conID' , $_POST['conID'])
				);

				if($_SESSION['accion']==='nuevo')
				{
					$padreID=$_POST['conID'];
				}
				else
				{
					$padreID=fetch_all
					(
						$con->query
						(
							'	SELECT PadreID 
								FROM Secciones
								WHERE ID='.$_POST['conID']
						),
						MYSQLI_NUM
					)[0][0];
				}

				$padreIDStr='='.$padreID;
			}

			if($_POST['Tipo']==='con')
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

				$contenido=new FormLabelContenido($this);

				if($this->srvBuilder->getAction()===0)
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
										WHERE ID='.$_POST['conID']
								),
								MYSQLI_NUM
							)[0][0],
							$_SESSION['lang']
						)
					);
				}

				$this->appendChild($contenido);
			}
			if($_POST['Tipo']==='inc')
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelModulos.php';

				$modulos=new FormLabelModulos($this);

				if($this->srvBuilder->getAction()===0)
				{
					$modulos->input->selectedValue=fetch_all
					(
						$con->query
						(
							'	SELECT ModuloID
								FROM Secciones
								WHERE ID='.$_POST['conID']
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
							'	SELECT Nombre , ID , Archivo 
								FROM Modulos 
								WHERE PadreID is NULL
							'
						),
						MYSQLI_NUM
					)
				);

				$this->clearFix()->appendChild
				(
					new VariablePost('conID' , $_POST['conID'])
				)->clearFix()->appendChild
				(
					$modulos
				);
			}

			if($_SESSION['accion']==='edita')
			{
				$padreIDStr.=' AND ID!='.$_POST['conID'];
			}

			$selectLugar->setOptionsFromSQLRes
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT HTMLID 
							FROM Secciones
							WHERE PadreID '.$padreIDStr.'
							ORDER BY Prioridad ASC
						'
					),
					MYSQLI_NUM
				)
			);
		}
	}
?>