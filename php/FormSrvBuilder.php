<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/FormSrvRecv.php';

	class FormSrvBuilder extends FormSrvRecv
	{
		public $ancla;
		public $docRoot;
		public $cantidad;
		public $headers;
		public $labels;

		function __construct($fId=NULL , $actions=NULL)
		{
			//Sacar lo que se necesite de acá, es ridiculo hacer referencia localmente a
			//una variable que se puede referenciar donde sea.
			parent::__construct($fId , $actions);

			$this->ancla="nCon";

			$this->cantidad=1;

			if(isset($_POST['cantidad']))
			{
				$this->cantidad=$_POST['cantidad'];
			}

			if(isset($_POST['conID']) && count($_POST['conID']))
			{
				$this->cantidad=count($_POST['conID']);
			}
		}
		
		public function getConfig()
		{
			//Incluyo la configuración del formulario en cuestión.
			include $_SERVER['DOCUMENT_ROOT'] . '//forms/config/'.$_POST['form'].'.php';
		}
		public function buildIncludes()
		{
			include $_SERVER['DOCUMENT_ROOT'] . '//php/head_include.php';

			$iMax=count($this->includes);

			for($i=0;$i<$iMax;$i++)
			{
				//echo '<pre>Include'.$includes[$i].'</pre>';
				head_include($this->includes[$i]);
			}
			unset($iMax);
		}
		public function buildForm()
		{
			$lMax=count($this->labels);

			$buff='';
			for($l=0;$l<$lMax;$l++)
			{
				$labelAct=$this->labels[$l];

				$tipo=$labelAct[0];
				$labelName=$labelAct[1];

				ob_start();
				
				?>
					<p class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<label for="<?php echo $labelName ?>"><?php echo $labelName ?>:</label>
					</p>

					<?php include $_SERVER['DOCUMENT_ROOT'] . '//forms/'.$tipo; ?>

					<div class="clearfix"></div>

				<?php

				$buff=$buff.ob_get_contents();
				ob_end_clean();
			}

			unset($l , $labelName , $labelAct , $labels);

			return $buff;
		}
		public function buildForms()
		{
			?>
				<form method="POST" class="tresem nuevo" action="<?php echo $this->referrer.$this->ancla ?>">
					<?php
						$iMax=$this->cantidad;

						for($i=0;$i<$iMax;$i++)
						{
							$this->autocomp=[];

							if($this->selectedAction===0 && isset($_SESSION['conID']))
							{
								$this->conIDAct=$_POST['conID'][$i];

								include $_SERVER['DOCUMENT_ROOT'] . '//forms/config/'.$_POST['form'].'Autocomp.php';
							}

							echo $this->buildForm();

							?>
								<div class="clearfix fin"></div>
							<?php
						}

						unset($i , $iMax);
					?>		
					<input type="submit" class="col-xs-12 col-sm-5 col-md-5 col-lg-5" name="Aceptar" value="Aceptar">
					<span class='hidden-xs col-sm-2 col-md-2 col-lg-2 '></span>
					<input type="submit" class="col-xs-12 col-sm-5 col-md-5 col-lg-5" name='Cancela' value="Cancelar">
				</form>
			<?php
		}
	}
?>