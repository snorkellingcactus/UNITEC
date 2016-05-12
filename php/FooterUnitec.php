<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Footer.php';

	class FooterUnitec extends Footer
	{
		function replaceIfEmpty(&$array , $lab)
		{
			foreach($array as $clave=>$valor)
			{
				if(empty($valor))
				{
					$array[$clave]=$lab->$clave;
				}
			}
		}
		function renderChilds(&$tag)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		    $lab=new Laboratorio();


			$lab->getSQL
			(
				[
					'ID'=>$_SESSION['lab']
				]
			);
			$labName=getLabName
			(
				$lab->ID ,
				$_SESSION['lang']
			);
			

		    $info=
		    [
		        'DireccionID' =>$lab->DireccionID,
		        'Mail'=>$lab->Mail ,
		        'Telefono'=> $lab->Telefono,
		        'Latitud'=> $lab->Latitud,
		        'Longitud'=> $lab->Longitud
		    ];

		    $social=
		    [
		        'Facebook' => $lab->Facebook,
		        'Twitter' => $lab->Twitter,
		    ];

	    	$defaultLab=getDefaultLabID();

	    	if($lab->ID!=$defaultLab)
		    {
		        $lab->getSQL
		        (
		            [
		            	'ID'=>$defaultLab
		            ]
		        );

		        $this->replaceIfEmpty($info , $lab);
		        $this->replaceIfEmpty($social , $lab);
		    }

		    $info['DireccionID']=getTraduccion
		    (
		    	$info['DireccionID'] ,
		    	$_SESSION['lang']
		    );

		    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMapa.php';

		    $mapa=new FooterMapa
		    (
		    	$labName ,
		    	$info['Latitud'].' , '.$info['Longitud']
		    );

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMail.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMapaForm.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMapa.php';

			$divInfo=new FooterInfo();

			if( $_SESSION['lab'] !== false )
			{
				$divInfo
				->setFacebook($social['Facebook'])
				->setTwitter($social['Twitter'])
				->setDireccion($info['DireccionID'])
				->setTelefono($info['Telefono'])
				->setMail($info['Mail']);
			}

			$titulo=new DOMTag
			(
				'h1',
				gettext('Nos interesa tu opinión!')
			);
			$mapScript=new Script('/footer.js');

			//$titulo->col=$divMail->col;;

			$this->appendChild
			(
				$titulo
			)->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				new FooterMail()
			)->appendChild
			(
				$divInfo
			)->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				$mapa
			)->appendChild
			(
				new FooterMapaForm()
			)->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				new DOMTag('small' , 'Powered by Bootstrap')
			)->appendChild
			(
				$mapScript->setAsync(true)->setDefer(true)
			);

			return parent::renderChilds($tag);
		}
	}
?>