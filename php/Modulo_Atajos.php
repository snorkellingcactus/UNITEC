<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Modulo.php';

	class Modulo_Atajos extends DOMInclude
	{
		function renderChilds(&$doc , &$tag)
		{
			$accessKeys=[	'[Alt]'	];

			$navStrings=
			[
				'Firefox'	=>	[gettext('Alt')		,	gettext('Shift')],
				'Mac OS X'	=>	[gettext('Control')	,	gettext('Alt')	]
			];

			$agent=$_SERVER['HTTP_USER_AGENT'];

			foreach($navStrings as $clave=>$valor)
			{
				if(strrpos($agent,$clave)!==FALSE)
				{
					$accessKeys=$valor;
				}
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTable.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMThead.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTbody.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTh.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTd.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTr.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTdAtajo.php';

			global $con;

			$condVisible='';
			if(!isset($_SESSION['adminID']))
			{
				$condVisible='AND Secciones.Visible=1';
			}

			$atajos=fetch_all
			(
				$con->query
				(
					'	SELECT Menu.Atajo , Menu.ContenidoID, Menu.SeccionID
						FROM Menu
						LEFT OUTER JOIN Secciones
						ON Secciones.HTMLID=Menu.SeccionID '.$condVisible.'
						LEFT OUTER JOIN TagsTarget
						ON TagsTarget.GrupoID=Secciones.TagsGrpID
						LEFT OUTER JOIN Laboratorios
						ON Laboratorios.ID='.$_SESSION['lab'].'
						WHERE TagsTarget.TagID=Laboratorios.TagID
						AND Menu.Atajo IS NOT NULL
					'
				),
				MYSQLI_ASSOC
			);

			$tabla=new DOMTable();
			$thead=new DOMThead();
			$tbody=new DOMTbody();
			$theadTr=new DOMTr();
			$tbodyTr=new DOMTr();
			$tbodyTdA=new DOMTd();

			$thSec=new DOMTh();
			$thTec=new DOMTh();

			$tabla->appendChild
			(
				$thead->appendChild
				(
					$theadTr->appendChild
					(
						$thSec->setTagValue
						(
							gettext('Sección')
						)
					)->appendChild
					(
						$thTec->setTagValue
						(
							gettext('Teclas')
						)
					)
				)
			)->appendChild
			(
				$tbody->appendChild
				(
					$tbodyTr->appendChild
					(
						$tbodyTdA->setTagValue
						(
							gettext('Inicio')
						)
					)->appendChild
					(
						new DOMTdAtajo($accessKeys , 'I')
					)
				)
			)->classList->add('atajos')->add('table');


			$i=0;
			while(isset($atajos[$i]))
			{
				$atajo=$atajos[$i];
				$tr=new DOMTr();
				$tdA=new DOMTd();

				if($i%2===0)
				{
					$tr->classList->add('oscura');
				}

				$tbody->appendChild
				(
					$tr->appendChild
					(
						$tdA->setTagValue
						(
							getTraduccion
							(
								$atajo['ContenidoID'],
								$_SESSION['lang']
							)	
						)
					)->appendChild
					(
						new DOMTdAtajo
						(
							$accessKeys,
							$atajo['Atajo']
						)
					)
				);

				++$i;
			}

			$this->appendChild
			(
				new OffText('h1' , gettext('Listado de atajos'))
			)->appendChild
			(
				$tabla
			);

			return parent::renderChilds($doc , $tag);
		}
	}
?>