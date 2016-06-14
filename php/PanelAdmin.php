<?php
/*
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
	class PAdmin_Modulo extends DOMTag
	{
		function __construct()
		{
			parent::__construct('div');
		}
		function setModuleName( $moduleName )
		{
			$this->moduleName=$moduleName;
		}
		function getList()
		{

		}
		function getDomList()
		{

		}
		function 
	}

	class PAdmin_Idiomas extends PAdmin_Modulo
	{
		function __construct()
		{
			parent::__construct();
		}
	}
*/
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	class PanelAdmin extends DOMTagContainer
	{
		private $modulosCol;

		function __construct()
		{
			parent::__construct();

			$this->modulosCol=[ 'xs' => 12 , 'sm' => 3 , 'md' => 3 , 'lg' => 3 ];

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/MSGBox.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMLink.php';
			//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_DOM.php';

			global $con;

			$usuario=fetch_all
			(
				$con->query
				(
					'	SELECT * FROM Usuarios
						WHERE ID='.$_SESSION['adminID']
				),
				MYSQLI_ASSOC
			)[0];

			$logueado=new MSGBox
			(
				gettext('Estas logueado!')
			);

			$cSesion=new DOMLink();

			$logueado->addToAttribute( 'class' , 'MSGLogin' );

			$this->appendChild
			(
				$logueado->appendChild
				(
					$cSesion->setUrl( '/inicio_sesion.php?cSesion' )->setName( gettext( 'Cerrar Sesión' ) )
				)
			);
		}
		function appendModulo( $modulo )
		{
			$modulo->col=&$this->modulosCol;

			return parent::appendChild($modulo);
		}
	}
?>