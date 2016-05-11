<?php
	function detectLab()
	{
		if(isset($_GET['lab']))
		{
			$lab=getLab(urldecode($_GET['lab']));

			if($lab!==false)
			{
				$_SESSION['lab']=$lab['ID'];

				return true;
			}
		}

		//if(!isset($_SESSION['lab']) || isset($_SESSION['adminID']))
		if
		(
			!	isset( $_SESSION['lab'] ) ||
			(
				!	isset( $_SESSION['lab']		) &&
					isset( $_SESSION['adminID']	)
			)
		)
		{
			$lab=getLab();

			if($lab!==false)
			{
				$_SESSION['lab']=$lab['ID'];
				return true;
			}
			else
			{
				$_SESSION['lab']=false;
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	function getLab()
	{
		$args=func_get_args();

		if(isset($args[0]))
		{
			$lab=getLabByName($args[0]);

			if(isset($lab[0]))
			{
				return $lab[0];
			}
		}
		
		$lab=getDefaultLab();

		if(isset($lab[0]))
		{
			return $lab[0];
		}
		return false;
	}
	function getDefaultLab()
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
		global $con;

		return fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.ID
					FROM Laboratorios
					WHERE PadreID is NULL
					LIMIT 1
				'
			),
			MYSQLI_ASSOC
		);
	}
	function getDefaultLabID()
	{
		$defaultLab=getDefaultLab();

		if(isset($defaultLab[0]))
		{
			return $defaultLab[0]['ID'];
		}
		else
		{
			return false;
		}
	}
	function getLabByTag($tag)
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
		global $con;

		return fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.*, Traducciones.Texto
					FROM Laboratorios
					LEFT OUTER JOIN Traducciones
					ON Traducciones.Texto="'.addslashes(trim($_GET['lab'])).'"
					LEFT OUTER JOIN Tags
					ON Tags.ID=Laboratorios.TagID
					WHERE Traducciones.ContenidoID=Tags.NombreID and Tags.ID = Laboratorios.TagID
					LIMIT 1
				'
			),
			MYSQLI_ASSOC
		);
	}
	function getLabByName($name)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		global $con;
/*
		echo '<pre>';
		print_r
		(
			htmlentities
			(
			'	SELECT Laboratorios.ID
				FROM Laboratorios
				LEFT OUTER JOIN Traducciones
				ON Traducciones.Texto="'.addslashes(htmlentities(trim($name))).'"
				WHERE Traducciones.ContenidoID=Laboratorios.NombreID
				LIMIT 1
			'
			)
		);
		echo '</pre>';
*/
		return fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.ID
					FROM Laboratorios
					LEFT OUTER JOIN Traducciones
					ON Traducciones.Texto="'.addslashes(htmlentities(trim($name))).'"
					LEFT OUTER JOIN Tags
                	ON Tags.ID=Laboratorios.TagID
					WHERE Traducciones.ContenidoID=Tags.NombreID
					LIMIT 1
				'
			),
			MYSQLI_ASSOC
		);
	}
	function getLabName()
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		global $con;
		$labID=$_SESSION['lab'];

		if(func_num_args())
		{
			$labID=func_get_args()[0];
		}

		$nameID=fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.NombreID
					FROM Laboratorios
					WHERE ID='.$labID
			),
			MYSQLI_NUM
		);

		if(isset($nameID[0][0]))
		{
			return getTraduccion
			(
				$nameID[0][0],
				$_SESSION['lang']
			);
		}

		return 'NoLab';
	}
	function getLabUrl($lName)
	{
		if(func_num_args()>1)
		{
			$lang=func_get_args()[1];
		}
		else
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/setLang.php';

			$lang=getLangCode();
		}

		return 'http://'.$_SERVER['SERVER_NAME'].'/'.$lang.'/espacios/'.rawurlencode(strtolower(trim($lName)));
	}
?>