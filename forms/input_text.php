<input type="text" name="<?php echo $labelName ?>[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8" 
<?php
	if(isset($autocomp[$labelName]))
	{
		?>
			value="<?php echo $autocomp[$labelName] ?>"
		<?php
	}
?>
>