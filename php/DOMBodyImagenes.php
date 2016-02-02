<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBody.php';

	class DOMBodyImagenes extends DOMBody
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function renderChilds(&$doc , &$tag)
		{
			
			//Si todavía no se inicio sesion, se inicia.
			$rw=1;
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/VisorImagenes.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$recLst=getPriorizados
			(
				fetch_all
				(
					$con->query
					(
						'	SELECT Imagenes.*
							FROM Imagenes
							LEFT OUTER JOIN TagsTarget
							ON TagsTarget.GrupoID=Imagenes.TagsGrpID
							LEFT OUTER JOIN Laboratorios
							ON Laboratorios.ID='.$_SESSION['lab'].'
							WHERE TagsTarget.TagID=Laboratorios.TagID
						'
					),
					MYSQLI_ASSOC
				)
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Visor.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Include_Context.php';

			$visorHTML=new VisorImagenes();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';

			$i=0;
			while(isset($recLst[$i]))
			{
				$imgAct=& $recLst[$i];
				
				if($visorHTML->add($imgAct['ID'] , $imgAct['AltID'] , $imgAct['TituloID'] , $imgAct['Fecha']))
				{
					$selected=$imgAct['TituloID'];
				}
				++$i;
			}

			$this->appendChild
			(
				$visorHTML->html
			);

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