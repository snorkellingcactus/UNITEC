<?php
function setLang($langName , $domain)
{
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

	bindtextdomain($domain , $_SERVER['DOCUMENT_ROOT'] . '/locale/nocache');
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
	$ro=1;
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php');
	unset($ro);

	global $con;

	$args=func_get_args();

	$domain='messages';
	if(isset($args[1]))
	{
		$domain=$args[1];
	}
	setLang
	(
		fetch_all
		(
			$con->query
			(
				'	SELECT Pais
					FROM Lenguajes
					WHERE ID='.$langID
			),
			MYSQL_NUM
		)[0][0],
		$domain
	);
}
function detectLang()
{
	include_once($_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php');

	start_session_if_not();

	if(!isset($_SESSION['lang']))
	{
		$_SESSION['lang']=1;
	}
	if(isset($_GET['lang']))
	{
		$_SESSION['lang']=intVal($_GET['lang']);
	}

	setLangFromID($_SESSION['lang']);
}
?>