<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepImgUploadBase.php';

	class SrvStepMenuBase extends SrvStepImgUploadBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			$this->addResize(32 , 32 , $_SERVER['DOCUMENT_ROOT'] . '/img/menu/');
		}
	}
?>
