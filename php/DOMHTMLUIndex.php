<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/HTMLUNormal.php';

	class DOMHTMLUIndex extends HTMLUNormal
	{
		public $body;
		public $main;
		public $menu;

		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMBodyUnitec.php';

			$this->setDescription
			(
				gettext('Página principal Unitec.')
			)->head_include
			(
				'/index.css'
			)->head_include
			(
				'/forms/forms.css'
			)->head_include
			(
				'/header.css'
			)->head_include
			(
				'/seccs/menu.css'
			)->head_include
			(
				'/seccs/contacto.css'
			)->head_include
			(
				'/js/head.js'
			)->head_include
			(
				'/js/compactaLabels.js'
			)->head_include
			(
				'/index.js'
			)->appendChild
			(
				$this->body=new DOMBodyUnitec()
			)->loadModulesHeaders();

			if( $_SESSION['lab'] !== false )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMMenuUnitec.php';
				
				$this->appendChild
				(
					$this->menu=new DOMMenuUnitec()
				);	
			}
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
			$this->appendChild
			(
				$this->main=new DOMTag('main')
			);

			if($_SESSION['lab'] !== false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterUnitec.php';

				$this->appendChild
				(
					new FooterUnitec()
				);

				$this->main->col=['xs'=>12 , 'sm'=>10 , 'md'=>10 , 'lg'=>10];
			}
			else
			{
				$this->main->col=['xs'=>12 , 'sm'=>12 , 'md'=>12 , 'lg'=>12];
			}

			
		}
		function loadModulesHeaders()
		{
			if($_SESSION['lab']!==false)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				global $con;

				$headers=fetch_all
				(
					$con->query
					(
						'	SELECT Modulos.Archivo FROM Modulos ,
								(
									SELECT Secciones.ModuloID FROM `Secciones` , 
									(
										SELECT ID from Secciones
										WHERE PadreID IS NULL
									) AS Secs
									WHERE Secciones.PadreID=Secs.ID
									AND Secciones.ModuloID IS NOT NULL
								) AS sub 
								WHERE Modulos.PadreID=sub.ModuloID
						'
					),
					MYSQLI_NUM
				);


				$h=0;
				while(isset($headers[$h]))
				{
					$this->head_include
					(
						$headers[$h][0]
					);
					++$h;
				}

				$this->setTitle(getLabName());
			}
			else
			{
				$this->setTitle('NoLab');
			}
		}
	}
?>