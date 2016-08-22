<?php
function setLang($langName , $domain)
{
	$langName=$langName.'.UTF-8';
/*	
	echo '<pre>langName:';
	print_r
	(
		$langName
	);
	echo '</pre>';
	echo '<pre>domain:';
	print_r
	(
		$domain
	);
	echo '</pre>';
*/
	
	//A futuro averiguar más variables de entorno.
	putenv('LANG='.$langName);
	setlocale(LC_ALL,$langName);

	//Revisar. Borrar esta línea para producción.
	//bindtextdomain($domain , $_SERVER['DOCUMENT_ROOT'] . '/locale/nocache');
	bindtextdomain($domain , $_SERVER['DOCUMENT_ROOT'] . '/locale');
	bind_textdomain_codeset($domain, 'UTF-8');
	textdomain($domain);
}
function setLangFromID($langID)
{
/*
	echo '<pre>langID:';
	print_r
	(
		$langID
	);
	echo '</pre>';
*/
	//$ro=1;
	$rw=1;
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
	//unset($ro);

	global $con;

	$args=func_get_args();

	$domain='messages';
	if(isset($args[1]))
	{
		$domain=$args[1];
	};

	setLang
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Lenguajes.Pais
					FROM Lenguajes
					WHERE ID='.$langID
			),
			MYSQL_NUM
		)[0][0],
		$domain
	);
}
function setLangFromName($name)
{
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
	//unset($ro);

	global $con;

	$_SESSION['lang']=fetch_all
	(
		$con->query
		(
			'	SELECT Lenguajes.ID
				FROM Lenguajes
				WHERE Lenguajes.Pais
				LIKE "'.$name.'%"
			'
		),
		MYSQLI_NUM
	)[0][0];

	return setLangFromID($_SESSION['lang']);
}

function detectLang()
{
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php');

	start_session_if_not();

	if( !isset( $_SESSION['lang'] ) )
	{
		//echo '<pre>Creando $_SESSION["lang"] con valor por defecto (1).';echo '</pre>';
		$_SESSION['lang']=1;
	}
	if( isset( $_GET['lang'] ) )
	{
		//echo '<pre>Existe un $_GET["lang"]. Se seteara.';echo '</pre>';
		setLangFromName
		(
			urldecode
			(
				trim
				(
					$_GET['lang']
				)
			)
		);

	}
	else
	{
		setLangFromID($_SESSION['lang']);
	}
}
function getLangCode()
{
	return substr( getenv( 'LANG' ), 0 , 2 );
}
function getTimeZone( )
{
	global $con;
	
	$args=func_get_args();

	if( isset( $args[0] ) )
	{
		$lang_id=$args[0];
	}
	else
	{
		$lang_id=$_SESSION['lang'];
	}

	return fetch_all
	(
		$con->query
		(
			'	SELECT Lenguajes.TimeZone
				FROM Lenguajes
				WHERE ID='.$lang_id
		),
		MYSQL_NUM
	)[0][0];
}
?>