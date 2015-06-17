<?php 
	$this->col=['xs'=>12 , 'sm'=>4 , 'md'=>4 , 'lg'=>4];
	
	include  $_SERVER['DOCUMENT_ROOT'] . '/forms/input_text.php'
?>
<div class="hidden-xs col-sm-1 col-md-1 col-lg-1" ></div>
<input type="file" name="<?php echo $labelName ?>_Archivo[]" class="col-xs-12 col-sm-3 col-md-3 col-lg-3" >