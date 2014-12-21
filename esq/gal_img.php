<div class="gImg col-xs-12 col-sm-6 col-md-4 col-lg-3">
	<?php
		if(isset($_SESSION['adminID']))
		{
			?>
				<input type="checkbox" class='eImg' name="eImgID[]" form="accionesGal" value="<?php echo $esq->ID ?>" />
			<?php
		}
	?>
	<button type="submit" form="vImg" name="vImgId" value="<?php echo $esq->ID ?>">
		<p>
			<?php echo $esq->Titulo ?>
		</p>
		<img src="<?php echo $esq->Url ?>" alt="<?php echo $esq->Alt ?>" width="200" height="200" />
	</button>
	
</div>