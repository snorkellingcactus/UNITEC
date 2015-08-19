<?php
	echo '<pre>Paso A</pre>';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/AgregarAlMenu.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormAtajo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormEditor.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class TituloBox extends FormLabelBox
	{
		public function __construct()
		{
			call_user_func_array
			(
				array
				(
					'parent','__construct'
				),
				func_get_args()
			);

			$cols=
			[
				'xs'=>12,
				'sm'=>12,
				'md'=>12,
				'lg'=>12
			];
			$this->label->setCol($cols)->classList->add('center');
			$this->input->setCol($cols);
		}
		function setInput($input)
		{
			$this->appendTag(new ClearFix());
			parent::setInput($input);
		}
	}

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
		$form->appendChild
		(
			new TituloBox
			(
				'Contenido',
				'contenido',
				'Contenido',
				new FormEditor()
			)
		);
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