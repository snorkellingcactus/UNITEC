<?php
	if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
	{
		?>
		<form action="<?php if(isset($fAction)){echo $fAction;} ?>" method="POST" id="<?php echo 'reload'.$fId ?>">
			<input type="hidden" name="form" value="acciones<?php echo $fId ?>">
			
			</p>
		</form>
		<?php
	}
?>