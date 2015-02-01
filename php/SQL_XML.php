<?php
if(session_status()==PHP_SESSION_NONE)
{
	session_start();
}
if(!empty($_SESSION['adminID']))
{
	$raiz=$_POST['raiz'];

	include_once('./conexion.php');
	include_once('./SQL_DOM.php');

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