<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Footer.php';

	class FooterUnitec extends Footer
	{
		function objEmpty( &$obj , $properties)
		{
			$empty=false;
			foreach( $properties as $clave=>$valor )
			{
				if( !isset( $obj[$valor] ) )
				{
					$empty = true;

					$obj[$valor]=NULL;
				}
			}

			return $empty;
		}
		function renderChilds(&$tag)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			$lab=getHeredatedLabData
			(
				$_SESSION['lab'],
				[
					'Mail' ,
					'Telefono' ,
					'Facebook' ,
					'Twitter' ,
					'DireccionID'
				],
				[
					'DireccionID'=>0
				]
			);

			$labName=getLabName();

	    	//Falta obtener direccionID en caso de que sea una traducción vacía.
	    	$infoIsEmpty=$this->objEmpty( $lab , [ 'Mail' , 'Telefono' ] );
	    	$socialIsEmpty=$this->objEmpty( $lab , [ 'Facebook' , 'Twitter' ] );

		    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMapa.php';

		    $labPos=getLabPos( $_SESSION['lab'] );
			if($labPos !== false)
			{
				$mapa=new FooterMapa
				(
					$labName ,
					$labPos[0].' , '.$labPos[1]
				);

				$mapScript=new Script( '/js/mapa.js' );
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMail.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMapaForm.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMapa.php';

			if(! ( $infoIsEmpty && $socialIsEmpty ) )
			{
				echo '<pre>Social is empty:';
				var_dump($socialIsEmpty);
				echo '</pre>';

				echo '<pre>Info is empty:';
				var_dump($infoIsEmpty);
				echo '</pre>';
				$divInfo=new FooterInfo();

				echo '<pre>DireccionID:';
				print_r($lab['DireccionID']);
				echo '</pre>';

				$divInfo
				->setFacebook	( $lab['Facebook']		)
				->setTwitter	( $lab['Twitter']		)
				->setDireccion	( $lab['DireccionID']	)
				->setTelefono	( $lab['Telefono']		)
				->setMail		( $lab['Mail']			);
			}

			$this->appendChild
			(
				new ClearFix()
			)->appendChild //Revisar. if isset( $footerMail )
			(
				$divMail=new FooterMail()
			);

			if( isset( $divInfo ) )
			{
				$this->appendChild
				(
					$divInfo
				);
			}

			$this->appendChild
			(
				new ClearFix()
			);

			if( isset( $mapa ) )
			{
				$this->appendChild
				(
					$mapa
				)->appendChild
				(
					$mapaForm=new FooterMapaForm()
				)->appendChild
				(
					new ClearFix()
				)->appendChild
				(
					$mapScript->setAsync(true)->setDefer(true)
				);
			}

			$this->appendChild
			(
				new DOMTag( 'small' , 'Powered by Bootstrap' )
			)->appendChild
			(
				new Script( '/footer.js' )
			);

			return parent::renderChilds($tag);
		}
	}
?>