<?php
	/**
	* @return bool
	*/
	function is_session_started()
	{
		if(php_sapi_name() !== 'cli' )
		{
			if( version_compare(phpversion(), '5.4.0', '>=') )
			{
				if(session_status() === PHP_SESSION_ACTIVE)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else 
			{
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	function start_session_if_not()
	{
		if( is_session_started() === FALSE )
		{
			session_start();
		}
	}
	function reload_session()
	{
		/*
			Recarga la sesion (la destruye y la vuelve a iniciar)
			pero conservando las variables pasadas por parámetro.
		*/
		$args=func_get_args();
		$toSave=array();

		start_session_if_not();

		$i=0;

		while(isset($args[$i]))
		{
			$name=$args[$i];
			if(isset($_SESSION[$name]))
			{
				//echo '<pre>$_SESSION['.$name.'] exists';echo '</pre>';

				$toSave[$i]=$_SESSION[$name];
			}

			++$i;
		}

		session_destroy();
		start_session_if_not();

		for($j=0;$j<$i;++$j)
		{
			if(isset($toSave[$j]))
			{
				//echo '<pre>$_SESSION['.$args[$j].'] = '.$toSave[$j];echo '</pre>';

				$_SESSION[$args[$j]]=$toSave[$j];
			}
		}
	}
?>