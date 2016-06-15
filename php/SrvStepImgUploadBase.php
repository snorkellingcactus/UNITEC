<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class SrvStepImgUploadBase extends SrvStepBase
	{
		public $resizes;
		public $resizesLen;

		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			$this->resizes=array();
			$this->resizesLen=0;
		}
		public function addResize($width , $height , $directory)
		{
			$this->resizes[$this->resizesLen]=array( $width , $height , $directory );

			++$this->resizesLen;

			return $this;
		}
		public function isEmpty($value)
		{
			return empty($value);
		}
		public function mkUrlArchivo($name , $tmpName , $imgID)
		{
			if($this->uploadImgOk($name))
			{
				//echo '<pre>mkUrlArchivo:'.htmlentities(' La ruta de la imagen es válida!');echo '</pre>';

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/phpthumb/ThumbLib.inc.php';
				try
				{
					$thumb=PhpThumbFactory::create($tmpName , ['resizeUp'=>true]);

					$iLen=$this->resizesLen;
					for($i=0;$i<$iLen;++$i)
					{
						$resize=$this->resizes[$i];

						//echo '<pre>'.htmlentities('mkUrlArchivo: Creando miniatura de '.$resize[0].' X '.$resize[1].' en '.$resize[2]);echo '</pre>';
						$thumb->resize($resize[0] , $resize[1])->save($resize[2].$imgID.'.png');
					}
					
					//echo '<pre>mkUrlArchivo:'.htmlentities(' Eliminando archivo temporal.'.$tmpName);echo '</pre>';

					include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';
					elimina($tmpName , 0755);
				}
				catch (Exception $e)
				{
					if( $e->getMessage() == 'Image file not found: ' )
					{
						echo '<pre>No se encontró';
						echo '</pre>';
						//$
					}
				}
			}
			
			else
			{
				//echo '<pre>mkUrlArchivo:'.htmlentities(' La ruta de la imagen es inválida!');echo '</pre>';
			}
		}
		public function mkUpload($i , $imgID , $session)
		{
			//Revisar. Redundante relativo a métodos recientes.
			if(isset($_FILES['Archivo']['name'][$i]))
			{
				if
				(
					!$this->isEmpty
					(
						trim
						(
							$_FILES['Archivo']['name'][$i]
						)
					)
				)
				{
					$name=$_FILES['Archivo']['name'][$i];
					$tmpName=$_FILES['Archivo']['tmp_name'][$i];
				}
			}

			if( !$session->emptyTrimLabel( 'Url' ) )
			{
				$name=$tmpName=$session->getLabel( 'Url' );
			}

			if(isset($name))
			{
				$this->mkUrlArchivo
				(
					$name,
					$tmpName,
					$imgID
				);
			}
		}
		//Revisar . Solo se usa al editar.
		function getUploadUrl( $url_new , $url_old )
		{
			$trimmed=trim( $url_new );

			if( !empty( $trimmed ) && $trimmed != $url_old )
			{
				return $trimmed;
			};

			return false;
		}
		//Exclusivo para uso con while.
		function isImgUploadEmpty( $session , $i )
		{

			return	$session->emptyTrimLabel( 'Url' ) &&
					empty( $_FILES['Archivo']['name'][$i] );
		}
		function uploadImgOk($name)
		{
			//echo '<pre>'.htmlentities('uploadImgOk: Chequeando ruta '.$name);echo '</pre>';

			if
			(
				$this->isEmpty
				(
					trim
					(
						$name
					)
				)
			)
			{
				//echo '<pre>uploadImgOk:'.htmlentities(' La ruta está vacía');echo '</pre>';
				return false;
			}
			$uploadOk=false;
				
			$extension=strtolower
			(
				pathinfo
				(
					$name,
					PATHINFO_EXTENSION
				)
			);
			//echo '<pre>'.htmlentities('uploadImgOk: Chequeando extensión '.$extension);echo '</pre>';
			if
			(
				$extension=='png'	|| $extension=='jpg' ||
				$extension=='jpeg'	|| $extension=='gif'
			)
			{
				return true;
			}
			return false;
		}
	}
?>