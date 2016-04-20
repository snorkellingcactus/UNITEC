<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecEditBase.php';

	class SrvFormSecEdit extends SrvFormSecEditBase
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSec.php';
			
			return new LabelsSec();
		}
		function autocomplete()
		{
			parent::autocomplete();

			$htmlID=fetch_all
			(
				$this->con->query
				(
					'	SELECT HTMLID
						FROM Secciones
						WHERE ID='.$this->labels->getContentID()
				),
				MYSQLI_NUM
			)[0][0];

			$this->labels->titulo->input->setValue
			(
				html_entity_decode
				(
					$htmlID
				)
			);

			$atajoSQL=fetch_all
			(
				$this->con->query
				(
					'	SELECT Atajo
						FROM Menu
						WHERE SeccionID="'.$htmlID.'"'
				),
				MYSQLI_NUM
			);

			if(isset($atajoSQL[0]))
			{
				$this->labels->atajo->input->setValue
				(
					$atajoSQL[0][0]
				);
			}
		}
	}
?>