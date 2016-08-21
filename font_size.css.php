<?php 
	header("Content-type: text/css; charset: UTF-8");
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
	start_session_if_not();
?>
body{font-size: <?php echo $_SESSION['FONT_SIZE'].'px' ?> }