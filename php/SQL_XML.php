<?php
if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}
if(!empty($_SESSION['adminID']))
{
	$raiz=$_POST['raiz'];

	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_DOM.php';

	$SQLDOM=new SQL_DOM
	(
		$con,
		[
			'Val'=>$raiz,
			'Tipo'=>'Raiz'
		]
	);

	$SQLDOM->resArbolXML();
}

?>