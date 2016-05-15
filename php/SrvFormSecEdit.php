<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecEditBase.php';

	class SrvFormSecEdit extends SrvFormSecEditBase
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSec.php';
			
			return new LabelsSec($index);
		}
		function autocomplete()
		{
			parent::autocomplete();

			$sec=fetch_all
			(
				$this->con->query
				(
					'	SELECT Secciones.TituloID, Secciones.AtajoID
						FROM Secciones
						WHERE Secciones.ID='.$this->labels->getContentID()
				),
				MYSQLI_NUM
			)[0];

			$this->labels->titulo->input->setValue
			(
				html_entity_decode
				(
					getTraduccion
					(
						$sec[0],
						$_SESSION['lang']
					)
				)
			);

			if( $sec[1] !== NULL )
			{
				$this->labels->atajo->input->setValue
				(
					getTraduccion
					(
						$sec[1],
						$_SESSION['lang']
					)
				);
			}

			$this->labels->aaMenu->input->controller->setValueToSelect
			(
				isset
				(
					fetch_all
					(
						$this->con->query
						(
							'	SELECT Menu.ID
								FROM Menu
								WHERE Menu.SeccionID = '.$this->labels->getContentID()
						),
						MYSQLI_NUM
					)[0][0]
				)
			);
		}
	}
?>