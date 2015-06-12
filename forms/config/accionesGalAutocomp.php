<?php
	if(isset($this->autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '//php/getTraduccion.php';

		$imagen=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Imagenes 
					WHERE TituloID='.$this->conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$this->autocomp['Url']=$imagen['Url'];
		$this->autocomp['Visible']=$imagen['Visible'];
		$this->autocomp['Prioridad']=$imagen['Prioridad'];
		$this->autocomp['Titulo']=getTraduccion($imagen['TituloID'] , $_SESSION['lang']);
	}
?>