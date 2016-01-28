<!-- Comentarios -->
<div class="comentarios col-lg-10 col-md-10 col-sm-10 col-xs-10" >
	<?php

		global $vRecID;

		$vRecID=$this->ContenidoID;
		$formCom=false;

		
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
		global $con;
		
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/ArbolComActions.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Arbol.php';

		//Prevenir la inclusión en vano, haciendo uso inteligente dentro de ArbolActions.
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliSelBase.php';

		//Genero los comentarios.
		$arbol=new Arbol
		(
			new ArbolComActions
			(
				new FormCliSelBase('accionesCom'),
				$this->ContenidoID,
				new DOMTagContainer()
			)
		);

		echo $arbol->solveDeps
		(
			fetch_all
			(
				$con->query
				(
					'	SELECT *
						FROM Comentarios
						WHERE Comentarios.RaizID ='.$this->ContenidoID.
					'	ORDER BY Fecha ASC'
				),
				MYSQLI_ASSOC
			),
			'PadreID',
			'ContenidoID',
			$this->ContenidoID
		)->render()->getHTML();

		
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliComPub.php';

		$jj=new FormCliComPub($this->ContenidoID);

		echo $jj->getHTML();

	?>
</div>
<div class="clearfix"></div>