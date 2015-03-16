<?php
if(!isset($max))
{
	$max=30;
}
if(!isset($min))
{
	$min=1;
}
?>
<select form="<?php echo $fId ?>" name="cantidad">
	<?php
		for($i=$min;$i<=$max;$i++)
		{
			?>
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?
		}
	?>
</select>