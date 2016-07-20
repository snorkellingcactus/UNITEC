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
		public function mkUrlArchivo($name , $tmpName , $imgID)
		{
			if($this->uploadImgOk($name))
			{
				//echo '<pre>mkUrlArchivo:'.htmlentities(' La ruta de la imagen es válida!');echo '</pre>';

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/PHPThumb/src/PHPThumb/PHPThumb.php';
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/PHPThumb/src/PHPThumb/GD.php';				
				try
				{
					$thumb=new PHPThumb\GD ($tmpName , ['resizeUp'=>true]);

					$iLen=$this->resizesLen;
					for($i=0;$i<$iLen;++$i)
					{
						$resize=$this->resizes[$i];

						//echo '<pre>'.htmlentities('mkUrlArchivo: Creando miniatura de '.$resize[0].' X '.$resize[1].' en '.$resize[2].$imgID);echo '</pre>';
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
						//echo '<pre>No se encontró';
						//echo '</pre>';
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
			//El orden de los if importa. Especificar un archivo debe tener prioridad.
			if( !$session->emptyTrimLabel( 'FileUrl' ) )
			{
				$name=$tmpName=$session->getLabel( 'FileUrl' );
			}
			//Revisar. Redundante relativo a métodos recientes.
			if( isset($_FILES['FileArchivo']['name'][$i]) )
			{
				if
				(
					!$this->isEmpty
					(
						trim
						(
							$_FILES['FileArchivo']['name'][$i]
						)
					)
				)
				{
					$name=$_FILES['FileArchivo']['name'][$i];
					$tmpName=$_FILES['FileArchivo']['tmp_name'][$i];
				}
			}

			if( isset( $name ) )
			{
				$this->mkUrlArchivo
				(
					$name,
					$tmpName,
					$imgID
				);
			}
		}
		public function isEmpty($value)
		{
			return empty($value);
		}
		//Revisar . Solo se usa al editar.
		function getUploadUrl( $url_new , $url_old )
		{
			$trimmed=trim( $url_new );

			if( !empty( $trimmed ) && ( $trimmed != $url_old ) )
			{
				return $trimmed;
			};

			return false;
		}
		function isImgFileEmpty( $i )
		{
			return empty( $_FILES['FileArchivo']['name'][$i] );
		}
		//Exclusivo para uso con while.
		function isImgUploadEmpty( $session , $i )
		{

			return	$session->emptyTrimLabel( 'FileUrl' ) &&
					$this->isImgFileEmpty( $i );
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
				
			//Revisar. Siendo posible urls, la url válida .jpg?urldata no pasa.
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