<?php
	function detectLab()
	{
		if(isset($_GET['lab']))
		{
			$lab=getLab(urldecode($_GET['lab']));

			if($lab !== false)
			{
				$_SESSION['lab']=$lab['ID'];

				return true;
			}
		}

		//if(!isset($_SESSION['lab']) || isset($_SESSION['adminID']))
		if
		(
			!isset( $_SESSION['lab'] ) 	||
			( $_SESSION['lab'] === "false" ) ||
			( $_SESSION['lab'] === false )
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
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
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
					ON Traducciones.Texto="'.trim( $tag ).'"
					LEFT OUTER JOIN Tags
					ON Tags.ID=Laboratorios.TagID
					WHERE Traducciones.ContenidoID=Tags.NombreID and Tags.ID = Laboratorios.TagID
					LIMIT 1
				'
			),
			MYSQLI_ASSOC
		)[0][0];
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

		if( isset( $nameID[0][0]) )
		{
			return getTraduccion
			(
				$nameID[0][0],
				$_SESSION['lang']
			);
		}

		return gettext( 'NoLab' );
	}
	function getLabAbbr( )
	{
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
				'	SELECT Laboratorios.Abbr
					FROM Laboratorios
					WHERE ID='.$labID
			),
			MYSQLI_NUM
		);

		if( isset( $nameID[0][0]) )
		{
			return $nameID[0][0];
		}

		return 0;
	}
	function getLabNameContainer()
	{
		if( getLabAbbr() )
		{
			return 'abbr';
		}
		else
		{
			return 'span';
		}
	}
	function getLabPosLoop($labID)
	{
		global $con;

		$lab=fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.PadreID, Laboratorios.Latitud, Laboratorios.Longitud
					FROM Laboratorios
					WHERE ID='.$labID
			),
			MYSQLI_NUM
		)[0];

		if
		(
			!empty( $lab[1] )	||
			!empty( $lab[2] )
		)
		{
			return [ $lab[1] , $lab[2] ];
		}

		if
		(
			( $lab[0] === NULL )
		)
		{
			return false;
		}

		return getLabPosLoop( $lab[0] );
	}
	function getLabPos($labID)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		global $con;

		return getLabPosLoop( $labID );
	}
	function getHeredatedLabDataLoop( $labID , $toFetch , $fetched, $txt )
	{
		global $con;

		$what='';

		$i=0;
		foreach( $toFetch as $clave=>$valor )
		{
			if($i>0)
			{
				$what=$what.', ';
			}

			$what=$what.'Laboratorios.'.$valor;

			++$i;
		}
		if($i===0)
		{
			return $fetched;
		}

		$lab=fetch_all
		(
			$con->query
			(
				'	SELECT Laboratorios.PadreID, '.$what.'
					FROM Laboratorios
					WHERE ID='.$labID
			),
			MYSQLI_ASSOC
		)[0];

		$i=0;
		foreach( $toFetch as $clave=>$valor )
		{
			if( ! empty( $lab[$valor]) )
			{
				if( isset( $txt[ $valor ] ) )
				{
					$lab[ $valor ] = getTraduccion
					(
						$lab[ $valor ] ,
						$_SESSION['lang']
					);

					unset( $txt[$valor] );
				}

				$fetched[$valor]=$lab[$valor];

				unset( $toFetch[$clave] );

				++$i;
			}
		}
		

		if
		(
			$lab['PadreID'] === NULL
		)
		{
			return $fetched;
		}

		return getHeredatedLabDataLoop( $lab['PadreID'] , $toFetch , $fetched , $txt );
	};
	function getHeredatedLabData($labID , $toFetch , $txt)
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';
		global $con;

		return getHeredatedLabDataLoop( $labID , $toFetch , [] , $txt);
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