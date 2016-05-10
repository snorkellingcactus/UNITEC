<?php	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepImgUploadBase.php';

	class SrvStepGalBase extends SrvStepImgUploadBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			$this
			->addResize(800 , 600 , $_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/')
			->addResize(280 , 210 , $_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/');
		}
	}
?>
