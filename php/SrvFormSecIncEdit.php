<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecOtherEdit.php';

	class SrvFormSecIncEdit extends SrvFormSecOtherEdit
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecInc.php';
			
			return new LabelsSecInc();
		}
		function autocomplete()
		{
			parent::autocomplete();

			$this->labels->modulos->input->setValueToSelect
			(
				fetch_all
				(
					$this->con->query
					(
						'	SELECT Secciones.ModuloID
							FROM Secciones
							WHERE ID='.$this->labels->getContentID()
					),
					MYSQLI_NUM
				)[0][0]
			);
		}
	}
?>