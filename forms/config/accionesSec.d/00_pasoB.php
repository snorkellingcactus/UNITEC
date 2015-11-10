<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugar.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelVisible.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTags.php';

	$selectLugar=new FormLabelLugar($this->form);
	$visible=new FormLabelVisible($this->form);
	$labelTags=new FormLabelTags($this->form);

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
	global $con;

	if($this->getAction()===0)
	{
		$visible->input->default=intVal
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT Visible
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0]
		);
	}
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

	if($this->getAction()===1)
	{
		$labelTags->input->setValue(getLabTagTree($_SESSION['lab']));
	}

	$this->form->appendChild
	(
		$selectLugar
	)->appendChild
	(
		new ClearFix()
	)->appendChild
	(
		$visible
	);

	if($_SESSION['Tipo']==='sec')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelTitulo.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAAMenu.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAtajo.php';

		$titulo=new FormLabelTitulo($this->form);
		$aaMenu=new FormLabelAAlMenu($this->form);
		$atajo=new FormLabelAtajo($this->form);

		if($this->getAction()===0)
		{
			$htmlID=fetch_all
			(
				$con->query
				(
					'	SELECT HTMLID
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0];

			$titulo->input->setValue
			(
				html_entity_decode
				(
					$htmlID
				)
			);
			$atajoSQL=fetch_all
			(
				$con->query
				(
					'	SELECT Atajo
						FROM Menu
						WHERE SeccionID="'.$htmlID.'"'
				),
				MYSQLI_NUM
			);
/*
			echo '<pre>ID Seleccionado:';
			print_r
			(
				$selectLugar->input->selectedValue
			);
			echo '</pre>';
*/

			if(isset($atajoSQL[0]))
			{
				$atajo->input->setValue($atajoSQL[0][0]);
			}
		}

		$this->form->appendChild
		(
			$titulo
		)->appendChild
		(
			$aaMenu
		)->appendChild
		(
			$atajo
		);

		$padreIDStr='IS NULL';
	}
	else
	{

		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

		$this->form->appendChild
		(
			new VariablePost($this->form , 'conID' , $_SESSION['conID'])
		);

		if($_SESSION['accion']==='nuevo')
		{
			$padreID=$_SESSION['conID'];
		}
		else
		{
			$padreID=fetch_all
			(
				$con->query
				(
					'	SELECT PadreID 
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
				),
				MYSQLI_NUM
			)[0][0];
		}

		$padreIDStr='='.$padreID;
	}

	if($_SESSION['Tipo']==='con')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelContenido.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		$contenido=new FormLabelContenido($this->form);

		if($this->getAction()===0)
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
								WHERE ID='.$_SESSION['conID']
						),
						MYSQLI_NUM
					)[0][0],
					$_SESSION['lang']
				)
			);
		}

		$this->form->appendChild($contenido);
	}
	if($_SESSION['Tipo']==='inc')
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelModulo.php';

		$modulos=new FormLabelModulo($this->form);

		if($this->getAction()===0)
		{
			$modulos->input->selectedValue=fetch_all
			(
				$con->query
				(
					'	SELECT Secciones.ModuloID
						FROM Secciones
						WHERE ID='.$_SESSION['conID']
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
					'	SELECT Nombre , ID
						FROM Modulos 
						WHERE PadreID is NULL
					'
				),
				MYSQLI_NUM
			)
		);

		$this->form->appendChild
		(
			new VariablePost
			(
				$this->form,
				'conID',
				$_SESSION['conID']
			)
		)->appendChild
		(
			$modulos
		);
	}

	if($this->getAction()===0)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Seccion.php';

		$selectLugar->input->selectedValue=$_SESSION['conID'];

		$grupoID=new Seccion(['ID'=>$_SESSION['conID']] , $con);
		$grupoID=$grupoID->getTagsGrp();

		if(isset($grupoID[0][0]))
		{
			$labelTags->input->setValue
			(
				getTagsStr($grupoID[0][0])
			);
		}
		else
		{
			echo '<pre>No group</pre>';
		}
	}

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

	$seccs=getPriorizados
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Secciones.HTMLID, Secciones.ID, Secciones.PrioridadesGrpID
					FROM Secciones
					LEFT OUTER JOIN TagsTarget
					ON TagsTarget.GrupoID=Secciones.TagsGrpID
					LEFT OUTER JOIN Laboratorios
					ON Laboratorios.ID='.$_SESSION['lab'].'
					WHERE Secciones.PadreID '.$padreIDStr.'
					AND TagsTarget.TagID=Laboratorios.TagID
				'
			),
			MYSQLI_ASSOC
		)
	);
	$s=0;
	while(isset($seccs[$s]))
	{
		$seccs[$s]=array
		(
			$seccs[$s]['HTMLID'],
			$seccs[$s]['ID']
		);
		++$s;
	}
	$selectLugar->setOptionsFromSQLRes
	(
		$seccs
	);
	

	$this->form->appendChild
	(
		$labelTags
	);
	if($this->thisIsLast())
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormContinuar.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormVolver.php';

		$this->form->appendChild(new FormContinuar($this->form))
		->appendChild(new FormVolver($this->form));

		$this->form->setAction($this->getStepUrlByName('90_SQL_Evts.php'));
	}
?>