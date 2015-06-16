<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

if(!empty($_SESSION['adminID']))
{
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/phpthumb/ThumbLib.inc.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';

	$img=new Img(['ID'=>$_GET['ImgID']]);
	$img->getSQL();
	
	$thumb=PhpThumbFactory::create($img->Url , ['resizeUp'=>true]);

	$thumb->resize(800 , 600)->save($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/'.$img->ID.'.png');
	$thumb->resize(280 , 210)->save($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/'.$img->ID.'.png');

	$thumb->show();
}
?>