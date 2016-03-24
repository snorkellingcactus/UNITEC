<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/DOMHTML.php';

	class DOMHTMLUnitecBase extends DOMHTML
	{
		function __construct()
		{
			parent::__construct();

			ini_set("display_errors", "On");

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

			if($_SESSION['lab']!==false)
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
		}
	}
?>