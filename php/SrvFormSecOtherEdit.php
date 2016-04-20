<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecEditBase.php';

	class SrvFormSecOtherEdit extends SrvFormSecEditBase
	{
		function autocomplete()
		{
			parent::autocomplete();

			$this->labels->setParentID
			(
				fetch_all
				(
					$this->con->query
					(
						'	SELECT PadreID 
							FROM Secciones
							WHERE ID='.$this->labels->getContentID()
					),
					MYSQLI_NUM
				)[0][0]
			);
		}
	}
?>