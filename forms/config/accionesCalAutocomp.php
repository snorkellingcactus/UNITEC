<?php
	if(isset($this->autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$evento=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Eventos 
					WHERE DescripcionID='.$this->conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$this->autocomp['Visible']=$evento['Visible'];
		$this->autocomp['Prioridad']=$evento['Prioridad'];
		$this->autocomp['Titulo']=$evento['Nombre'];
		$this->autocomp['Fecha']=$evento['Tiempo'];
		$this->autocomp['Descripcion']=getTraduccion($evento['DescripcionID'] , $_SESSION['lang']);

		//echo '<pre>Evento:';print_r($evento);echo '</pre>';
	}
?>