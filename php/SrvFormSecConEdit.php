<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecOtherEdit.php';

	class SrvFormSecConEdit extends SrvFormSecOtherEdit
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Editar Contenido ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecCon.php';
			
			return new LabelsSecCon($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/revertSplitInlineCss.php';
				
			$this->labels->contenido->input->setValue
			(
				revertSplitInlineCss
				(
					getTraduccion
					(
						$content_id=fetch_all
						(
							$this->con->query
							(
								'	SELECT ContenidoID
									FROM Secciones
									WHERE ID='.$this->labels->getContentID()
							),
							MYSQLI_NUM
						)[0][0],
						$_SESSION['lang']
					),
					$content_id
				)
			);
		}
	}
?>