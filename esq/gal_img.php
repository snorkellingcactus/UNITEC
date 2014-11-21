<div class="gImg col-xs-12 col-sm-6 col-md-4 col-lg-3">
	<a href="index.php?vImgID=<?php echo $esq->ID ?>#gal" >
		<p>
			<?php echo $esq->Titulo ?>
		</p>
		<img src="<?php echo $esq->Url ?>" width="200" height="200" />
	</a>
	<?php
	if(isset($_SESSION['adminID']))
	{
		?>
		<a class="eImg" href="index.php?eImgID=<?php echo $esq->ID ?>#gal">x</a>
		<?php
	}
	?>
	
</div>