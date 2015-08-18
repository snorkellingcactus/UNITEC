<?php
	echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOrden.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

	$form=new DOMTagContainer();

	$sOrden=new FormSelectOrden
			(
				[
					'LugarA',
					'LugarB',
					'LugarC'
				],
				2
			);
	$form->appendTag
	(
		new FormLabelBox
		(
			'Lugar',
			'lugar',
			'Lugar',
			$sOrden->autoAddOptions()
		)
	)->appendTag
	(
		new FormLabelBox
		(
			'Visible',
			'visible',
			'Visible',
			new FormSelectBool('Si','No')
		)
	);
	//echo $form->getHTML();

	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';

	$lMax=count($this->labels);

	if($_POST['Tipo']==='sec')
	{
		$form->appendTag
		(
			new FormLabelBox
			(
				'Titulo',
				'titulo',
				'Titulo',
				new FormInput('text')
			)
		)->appendTag
		(
			new FormLabelBox
			(
				'AgregarAlMenu',
				'agregarAlMenu',
				'Agregar al Menú',
				new FormSelectBool('Si','No')
			)
		)->appendTag
		(
			new FormLabelBox
			(
				'Atajo',
				'atajo',
				'Atajo',
				new FormInput('text')
			)
		);
		$padreIDStr='IS NULL';
	}
	else
	{
		$form->appendTag
		(
			new FormLabelBox
			(
				'conID',
				'conID',
				'conID',
				new FormInput('hidden')
			)
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
		$form->appendTag
		(
			new FormLabelBox
			(
				'conID',
				'conID',
				'conID',
				new FormInput('hidden')
			)
		)->appendTag
		(
			new FormLabelBox
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

	echo $form->getHTML();
?>