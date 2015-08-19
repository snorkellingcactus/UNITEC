<?php
	echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/AgregarAlMenu.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormAtajo.php';

	$form=$this->form;

	$form->appendChild
	(
		new FormLugar()
	)->appendChild
	(
		new ClearFix()
	)->appendChild
	(
		new FormVisible()
	);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';

	$lMax=count($this->labels);

	if($_POST['Tipo']==='sec')
	{

		$form->appendChild
		(
			new ClearFix()
		)->appendChild
		(
			new FormTitulo()
		)->appendChild
		(
			new ClearFix()
		)->appendChild
		(
			new AgregarAlMenu()
		)->appendChild
		(
			new ClearFix()
		)->appendChild
		(
			new FormAtajo()
		);

		$padreIDStr='IS NULL';
	}
	else
	{

		$form->appendChild
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
		$this->labels[$lMax+1]=
		[
			'editor.php',
			'Contenido'
		];
	}
	if($_POST['Tipo']==='inc')
	{
		$form->clearFix()->appendChild
		(
			new VariablePost('conID' , $_POST['conID'])
		)->clearFix()->appendChild
		(
			new LabelBox
			(
				'Modulo',
				'modulo',
				'Modulo',
				new FormSelect
				(
					new FormOption('ModuloA',0),
					new FormOption('ModuloB',1)
				)
			)
		);
	}

	if($_SESSION['accion']==='edita')
	{
		$padreIDStr.=' AND ID!='.$_POST['conID'];
	}
	$_POST['lleno']=fetch_all
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
	);
?>