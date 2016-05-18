<?php
	class StepNameFormatter
	{
		private $number;

		private $name;
		private $fileName;

		private $localUrl;
		private $clientUrl;

		private $formDir;
		private $actionUrl;

		function __construct($formDir , $actionUrl)
		{
			$this->number=false;
			$this->fileName=false;
			$this->formDir=false;

			$this->actionUrl=$actionUrl;
			$this->formDir=$formDir;
		}

		public function setFileName($fileName)
		{
			$this->fileName=$fileName;

			$this->number=floatVal
			(
				substr
				(
					$fileName,
					0,
					2
				)
			);

			$this->name=$this->fNameWithNoExt
			(
				substr
				(
					$fileName,
					3,
					strpos($fileName, '.')
				)
			);

			return $this->updateLocalUrl();
		}
		public function getFormattedName()
		{
			return $this->name;
		}
		public function setNumber($number)
		{
			$this->number=floatVal($number);

			//Reemplazar partes con constantes como RouterPaths::ActionPath (= 'php/accion.php')
			$this->clientUrl=$this->actionUrl.'?step='.$number;

			return $this;
		}
		public function getFormattedNumber()
		{
			$number=$this->number;
			$strPrefix='';

			//Revisar. ¿Funciona?
			if($number<10)
			{
				$strPrefix='0';
			}

			return $strPrefix.$number;
		}
		public function setFormDir($formDir)
		{
			$this->formDir=$formDir;

			return $this->updateLocalUrl();
		}
		private function updateLocalUrl()
		{
			if
			(
				$this->formDir === false	||
				$this->fileName	=== false
			)
			{
				return $this;
			}

			$this->localUrl=$this->formDir.$this->fileName;

			return $this;
		}

		//Revisar. Un metodo genérico, de utilidad en general.
		private function fNameWithNoExt($filename)
		{
			while(pathinfo($filename , PATHINFO_EXTENSION) !== '')
			{
				$filename=pathinfo($filename , PATHINFO_FILENAME);
			}

			return $filename;
		}
		public function getClientUrl()
		{
			return $this->clientUrl;
		}
/*
		public function setClientUrl($clientUrl)
		{

			$clientUrl=trim( $clientUrl );

			$pos=strrpos
			(
				$clientUrl ,
				'?step='
			);

			if($pos !== false)
			{
				//Revisar. Seguridad
				return $this->setNumber
				(
					substr
					(
						$clientUrl,
						+6
					)
				);
			}
			else
			{
				return false;
			}
		}
*/
		public function getLocalUrl()
		{
			return $this->localUrl;
		}
	}
?>