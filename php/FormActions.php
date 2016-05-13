<?php
	/**
	* 
	*/
	class FormActions
	{

		const FORM_ACTIONS_EDIT		=	1;
		const FORM_ACTIONS_NEW		=	2;
		const FORM_ACTIONS_DELETE	=	4;
		const FORM_ITEM_TYPE_A		=	8;
		const FORM_ITEM_TYPE_B		=	16;
		const FORM_ITEM_TYPE_C		=	32;
		const FORM_ACTION_PREFIX	=	'ACTION';

		//http://stackoverflow.com/questions/2791869/most-efficient-way-to-extract-bit-flags
		public static function isFlagSet($Flag,$Setting,$All=false)
		{
		  $setFlags = $Flag & $Setting;
		  if($setFlags and !$All) // at least one of the flags passed is set
		     return true;
		  else if($All and ($setFlags == $Flag)) // to check that all flags are set
		     return true;
		  else
		     return false;
		}

		public static function checkActionIn($arr)
		{
			$prefix=FormActions::FORM_ACTION_PREFIX;

			foreach($arr as $name=>$value)
			{
				if(substr($name , 0 , 6)===$prefix)
				{
					return intVal
					(
						substr
						(
							$name ,
							strlen($prefix)
						)
					);
				}
			}

			return false;
		}
		public static function &checkContentIDIn($arr)
		{
			if(isset($arr['conID']))
			{
				return $arr['conID'];
			}

			$res=false;

			return $res;
		}
		public static function &getContentID()
		{

			//Revisar . Seguridad.
			$contentID=FormActions::checkContentIDIn($_POST);

			if($contentID===false)
			{
				$contentID=FormActions::checkContentIDIn($_SESSION);
			}

			return $contentID;
		}
		public static function replaceSessionAction($oldAction , $action)
		{
			unset
			(
				$_SESSION[FormActions::FORM_ACTION_PREFIX.strval($oldAction)]
			);

			FormActions::setSessionAction($action);
		}
		public static function setSessionAction($action)
		{
			$_SESSION[FormActions::FORM_ACTION_PREFIX.strval($action)]=true;
		}
	}
?>