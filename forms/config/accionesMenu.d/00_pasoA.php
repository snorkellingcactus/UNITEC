<?php
	//echo '<pre>Paso A</pre>';
	
	if(isset($_POST['conID']))
	{
		$this->cantidad=count($_POST['conID']);
	}

	if($this->getAction()===2)
	{
		$this->redirectToStepName('90_SQL_Evts.php');
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelUrl.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';


	$titulo=new FormLabelTitulo($this->form);
	$url=new FormLabelUrl($this->form);
	$lugar=new FormLabelLugar($this->form);
	$visible=new FormLabelVisible($this->form);
	$tags=new FormLabelTags($this->form);

	$visible->input->default=1;

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
	global $con;

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';

		$opcion=new Menu(null , $con);
		$opcion->getSQL(['ContenidoID'=>$_POST['conID']]);
/*
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
*/
		$url->input->setValue($opcion->Url);
		$visible->input->default=$opcion->Visible;
		//$this->form->autocomp['Prioridad']=$opcion['Prioridad'];
		$titulo->input->setValue
		(
			getTraduccion
			(
				$opcion->ContenidoID,
				$_SESSION['lang']
			)
		);

		$lugar->input->selectedValue=$_POST['conID'];

		$grupoID=$opcion->getTagsGrp();

		if(isset($grupoID[0][0]))
		{
			$tags->input->setValue
			(
				getTagsStr($grupoID[0][0])
			);
		}
	}
	if($this->getAction()===1)
	{
		$tags->input->setValue(getLabTagTree($_SESSION['lab']));
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
/*
	echo '<pre>Consulta:';
	print_r
	(
		'	SELECT Menu.ContenidoID, Menu.ContenidoID, Menu.PrioridadesGrpID
			FROM Menu
			LEFT OUTER JOIN TagsTarget
			ON TagsTarget.GrupoID=Menu.TagsGrpID
			LEFT OUTER JOIN Laboratorios
			ON Laboratorios.ID='.$_SESSION['lab'].'
			WHERE TagsTarget.TagID=Laboratorios.TagID
		'
	);
	echo '</pre>';
*/
	$lleno=getPriorizados
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Menu.ContenidoID, Menu.ContenidoID, Menu.PrioridadesGrpID
					FROM Menu
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID=Menu.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE TagsTarget.TagID=Laboratorios.TagID
				'
			),
			MYSQLI_ASSOC
		)
	);

	$iMax=count($lleno);
	for($i=0;$i<$iMax;$i++)
	{
		$conID=$lleno[$i]['ContenidoID'];
		$lleno[$i]=array
		(
			getTraduccion
			(
				 $conID ,
				 $_SESSION['lang']
			),
			$conID
		);
	}

	$lugar->setOptionsFromSQLRes
	(
		$lleno
	);

	$this->form->appendChild($titulo)
	->appendChild(new ClearFix())
	->appendChild($url)
	->appendChild(new ClearFix)
	->appendChild($lugar)
	->appendChild(new ClearFix())
	->appendChild($tags)
	->appendChild(new ClearFix())
	->appendChild($visible);

	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormContinuar($this->form))
		->appendChild(new FormVolver($this->form));

		$this->form->setAction($this->getStepUrlByName('90_SQL_Evts.php'));
	}
?>