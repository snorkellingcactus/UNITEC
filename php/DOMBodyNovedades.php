<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

	class DOMBodyNovedades extends DOMBody
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function renderChilds(&$doc , &$tag)
		{
			$rw=1;
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Obj.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/VisorNovedades.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMTagLst.php';

			global $con;

			$mainNov=false;

			if(isset($_GET['vRecID']))
			{
				$vRecID=intVal($_GET['vRecID']);

				$queryStr='	SELECT Novedades.* FROM `Novedades`
							WHERE ID='.intVal($_GET['vRecID']);
			}
			else
			{
				$queryStr='	SELECT Novedades.* FROM `Novedades`
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Novedades.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE TagsTarget.TagID=Laboratorios.TagID
							ORDER BY Fecha DESC
							LIMIT 1
						';
			}

			$mainNov=fetch_all
			(
				$con->query($queryStr),
				MYSQLI_ASSOC
			)[0];

			$recLst=getPriorizados
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT DISTINCT Novedades.*
							FROM
							Novedades,
							(
								SELECT Novedades.ID, TagsTarget.TagID
								FROM Novedades
								LEFT OUTER JOIN TagsTarget
							    ON TagsTarget.GrupoID=Novedades.TagsGrpID
							) as NToTag1,
							(
								SELECT Novedades.ID, TagsTarget.TagID
								FROM Novedades
								LEFT OUTER JOIN TagsTarget
							    ON TagsTarget.GrupoID=Novedades.TagsGrpID
							) as NToTag2
							WHERE NToTag1.ID=Novedades.ID
							AND NToTag1.TagID=NToTag2.TagID
							AND NToTag2.ID='.$mainNov['ID'].'
							AND Novedades.ID!='.$mainNov['ID'].'
							ORDER BY NToTag1.ID
							LIMIT 5
						'
					),
					MYSQLI_ASSOC
				)
			);

			$visorHTML=new VisorNovedades();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

			$visorHTML->add
			(
				$mainNov['ID'],
				$mainNov['ImagenID'],
				$mainNov['TituloID'],
				$mainNov['DescripcionID'],
				$mainNov['TagsGrpID']
			);

			$selected=$mainNov['TituloID'];
			
			$sugeridas=new DOMTag('section');

			$i=0;
			while(isset($recLst[$i]))
			{
				$nov=& $recLst[$i];

				$container=new DOMTag('div');
				$container->classList->add('gImg');
				$container->col=['xs'=>12 , 'sm'=>6 , 'md'=>4 , 'lg'=>3];

				$link=new DOMTag('a');

				$text=new DOMTag
				(
					'p',
					getTraduccion
					(
						$nov['TituloID'] ,
						$_SESSION['lang']
					)
				);

				$img=new DOMTag('img');
				//$img->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12 ];

				//Extraido de esq/novedad.php

				$fechaStr=new DateTime();
				$fechaStr->createFromFormat('Y-m-d H:i:s' , $nov['Fecha']);

				$fechaYmd=strftime
				(
					'%Y-%m-%d',
					$fechaStr->getTimestamp()
				);

				$sugeridas->appendChild
				(
					$container->appendChild
					(
						$link->appendChild($text)->appendChild
						(
							$img->setAttribute
							(
								'src' ,
								$visorHTML->formatUrlB($nov['ImagenID'])
							)
						)->setAttribute
						(
							'href',
							$link='/'.getLangCode().'/espacios/'.getLabName().'/novedades/'.$fechaYmd.'/'.urlencode(str_replace('/' , ' ' , getTraduccion($nov['TituloID'] , $_SESSION['lang']))).'-'.$nov['ID']
						)
					)
				);

				++$i;
			}

			$this->appendChild($visorHTML->html);

			if($i)
			{
				$sugeridas->classList->add('sugeridas')->add('novedades');
				$sugeridas->col=['lg'=>10 , 'md'=>10 , 'sm'=>10 , 'xs'=>10];

				$this->appendChild($sugeridas);
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Arbol_Comentarios.php';
			
			$comentarios=new Arbol_Comentarios($selected);
			
			$this->appendChild
			(
				$comentarios->render()
			);
			return parent::renderChilds($doc , $tag);
		}
	}
?>