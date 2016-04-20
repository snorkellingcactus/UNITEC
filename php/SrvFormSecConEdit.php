<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecOtherEdit.php';

	class SrvFormSecConEdit extends SrvFormSecOtherEdit
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecCon.php';
			
			return new LabelsSecCon();
		}
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
				
			$this->labels->contenido->input->setValue
			(
				getTraduccion
				(
					fetch_all
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
				)
			);
		}
	}
?>