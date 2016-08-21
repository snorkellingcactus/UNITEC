<?php
	function procCStyleLoop( $file_path , $id , procCActions $actions )
	{

		$id_main_strlen=strlen( $id )+2; //#s1234

		$n_line_pot10=10;
		$n_line_strlen=1;

		$id_strlen=$id_main_strlen+$n_line_strlen;

		$n_line=0;

		$f_handle=fopen( $file_path , 'r' );
		
		while( ( $line=fgets( $f_handle , 1024 ) ) && $actions->noStop() )
		{
			if( $n_line === $n_line_pot10 )
			{
				++$n_line_strlen;

				$n_line_pot10=$n_line_pot10*10;

				$id_strlen=$id_main_strlen+$n_line_strlen;
			}

			$actions->whatToDo( substr( $line , $id_strlen ) , $n_line );

			//else{echo '<pre>Discard line: "'.htmlentities( $line );echo '"</pre>';}

			++$n_line;
		}

		fclose( $f_handle );
	}
?>