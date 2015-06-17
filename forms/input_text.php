<input type="text" name="<?php echo $labelName ?>[]" class="<?php echo $this->mkCol() ?>" 
<?php
	if(isset($this->autocomp[$labelName]))
	{
		?>
			value="<?php echo $this->autocomp[$labelName] ?>"
		<?php
	}
?>
>