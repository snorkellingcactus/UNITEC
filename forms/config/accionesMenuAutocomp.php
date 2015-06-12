<?php
	if(isset($this->autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$opcion=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Menu 
					WHERE ContenidoID='.$this->conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$this->autocomp['Url']=$opcion['Url'];
		$this->autocomp['Lenguaje']=$_SESSION['lang'];
		$this->autocomp['Visible']=$opcion['Visible'];
		$this->autocomp['Prioridad']=$opcion['Prioridad'];
		$this->autocomp['Titulo']=getTraduccion($opcion['ContenidoID'] , $_SESSION['lang']);
	}
?>