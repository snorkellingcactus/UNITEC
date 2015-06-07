<?php
if(isset($autocomp[$labelName]))
{
	$autocompSiNo=$autocomp[$labelName];
}
else
{
	$autocompSiNo=0;
}
?>
<select name="<?php echo $labelName ?>[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
	<option value="1" <?php if(isset($autocompSiNo) && $autocompSiNo===0){?>selected="selected"<?} ?>>Si</option>
	<option value="0" <?php if(isset($autocompSiNo) && $autocompSiNo===1){?>selected="selected"<?} ?>>No</option>
</select>