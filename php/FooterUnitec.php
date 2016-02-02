<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Footer.php';

	class FooterUnitec extends Footer
	{
		function __construct()
		{
			parent::__construct();
		}
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
		function renderChilds(&$doc , &$tag)
		{
			if(isset($_SESSION['lab']))
			{
			    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			    include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

			    $lab=new Laboratorio();
			    $lab->getSQL(['ID'=>$_SESSION['lab']]);


			    $labName=getTraduccion($lab->NombreID , $_SESSION['lang']);

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

			   
			    $defaultLab=getDefaultLab()[0]['ID'];

			    if($lab->ID!=$defaultLab)
			    {
			        $lab->getSQL
			        (
			            ['ID'=>$defaultLab]
			        );

			        $this->replaceIfEmpty($info , $lab);
			        $this->replaceIfEmpty($social , $lab);
			    }

			    $info['DireccionID']=getTraduccion($info['DireccionID'] , $_SESSION['lang']);
			    
			    $latLong=$info['Latitud'].' , '.$info['Longitud'];
			}

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMail.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterInfo.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMapa.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FooterMapaForm.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliMapa.php';

			$divInfo=new FooterInfo();

			$titulo=new DOMTag
			(
				'h1',
				gettext('Nos interesa tu opinión!')
			);

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
				->setFacebook($social['Facebook'])
				->setTwitter($social['Twitter'])
				->setDireccion($info['DireccionID'])
				->setTelefono($info['Telefono'])
				->setMail($info['Mail'])
			)->appendChild
			(
				new ClearFix()
			)->appendChild
			(
				new FooterMapa($labName , $latLong)
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
				new Script('/footer.js')
			);

			return parent::renderChilds($doc , $tag);
		}
	}
?>