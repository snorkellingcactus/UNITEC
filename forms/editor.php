<div class="clearfix"></div>
<textarea id="editor" name="Descripcion[]" class="col-xs-12 col-sm-8 col-md-8 col-lg-8" rows='7'/>
	<?php
		if(isset($this->autocomp[$labelName]))
		{
			echo $this->autocomp[$labelName];
		}
	?>
</textarea>
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('editor');
</script>