<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTML.php';

	ini_set("display_errors", "On");
	error_reporting(E_ALL);

	class DOMHTMLUnitecBase extends DOMHTML
	{
		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getLab.php';

			if(isset($_GET['sesdest']))
			{
				session_start();
				session_destroy();
				session_start();
			}

			detectLang();
			detectLab();

			$this->setLang
			(
				substr
				(
					getenv('LANG'), 0 , 2
				)
			);

			$this->appendMeta
			(
				$this->newMeta()->setHttpEquiv('X-UA-Compatible')->setContent('IE=edge')
			)->appendMeta
			(
				$this->newMeta()->setHttpEquiv('viewport')->setContent('width=device-width, initial-scale=1')
			)->head_include
			(
				'/bootstrap.css'
			);

			if( $_SESSION['lab']!==false )
			{
				//Revisar. A futuro crear un .ico para SIcon.
				$logo='/img/logos/'.$_SESSION['lab'].'.png';

				$this->setIcon
				(
					$logo
				)->setSIcon
				(
					$logo
				);
			}
			if( !isset( $_SESSION['FONT_SIZE'] ) )
			{
				echo '<pre style="float:right">';
				print_r($_SESSION);
				echo '</pre>';
				$_SESSION['FONT_SIZE']=14;
			}
		}
		function renderChilds( &$tag )
		{
			$this->includeCSS( '/font_size.css.php' );

			return parent::renderChilds( $tag );
		}
	}
?>