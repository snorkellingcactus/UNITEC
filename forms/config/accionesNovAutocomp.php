<?php
	if(isset($this->autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$novedad=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Novedades 
					WHERE ID='.$this->conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$this->autocomp['Visible']=$novedad['Visible'];
		$this->autocomp['Prioridad']=$novedad['Prioridad'];
		$this->autocomp['Imagen']=$novedad['ImagenID'];
		$this->autocomp['Descripcion']=getTraduccion($novedad['DescripcionID'] , $_SESSION['lang']);
		$this->autocomp['Titulo']=getTraduccion($novedad['TituloID'] , $_SESSION['lang']);
	}
?>