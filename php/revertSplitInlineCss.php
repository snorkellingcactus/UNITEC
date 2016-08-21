<?php
	function revertSplitInlineCss( $content , $content_id )
	{
		$f_name=$_SERVER['DOCUMENT_ROOT'].'/css/generated/'.$content_id.'.css';
		
		if( file_exists( $f_name ) )
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/procCStyleLoop.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/procCStyleRead.php';
			
			procCStyleLoop( $f_name , $content_id , $lines=new procCStyleRead() );

			$f_lines=$lines->getLinesArray();

			$content=preg_replace_callback
			(
				'/id="s'.$content_id.'([0-9]+)"/',
				function( $matches ) use ( &$f_lines , &$n_line )
				{
					return 'style="'.str_replace
					(
						['{' , "\n" , '}'] ,
						'' ,
						$f_lines[ $matches[1] ]
					).'"';
				},
				$content
			);
		}

		return $content;
	}
?>