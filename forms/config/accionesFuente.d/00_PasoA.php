<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepCommon.php';

	class PasoA extends SrvStepCommon
	{
		function onDelete(  )
		{
			$newVal=floatVal( $_SESSION['FONT_SIZE'] )-1;
			if( $newVal >= 0 )
			{
				$_SESSION['FONT_SIZE']=$newVal;
			}
		}
		function onNew(  )
		{
			$_SESSION['FONT_SIZE']=floatVal( $_SESSION['FONT_SIZE'] )+1;
		}
		function onSetRouter()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
			start_session_if_not();

			parent::onSetRouter();

			$this->getRouter()->gotoOrigin();
		}
	}
?>