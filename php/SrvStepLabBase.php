<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepImgUploadBase.php';

	class SrvStepLabBase extends SrvStepImgUploadBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			$this->addResize(64 , 64 , $_SERVER['DOCUMENT_ROOT'] . '/img/logos/');
		}
	}
?>
