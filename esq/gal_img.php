<div class="gImg col-xs-12 col-sm-6 col-md-4 col-lg-3">
	<?php
		if(isset($_SESSION['adminID']))
		{
			?>
				<input type="checkbox" class='eImg' name="eImgID[]" form="acciones" value="<?php echo $esq->ID ?>" />
			<?php
		}
	?>
	<a href="index.php?vImgID=<?php echo $esq->ID ?>#gal" >
		<p>
			<?php echo $esq->Titulo ?>
		</p>
		<img src="<?php echo $esq->Url ?>" alt="<?php echo $esq->Alt ?>" width="200" height="200" />
	</a>
	
</div>