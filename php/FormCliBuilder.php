<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCfg.php';

	class FormCliBuilder extends FormCfg
	{
		private $fNom;
		public $fType;
		public 	$cMax;
		public $actionUrl;
		public $raiz;

		public function __construct($fId , $cMax=0)
		{
			parent::__construct($fId);

			$this->raiz='http://'. $_SERVER['SERVER_NAME'].'/';
			$this->actionUrl=$this->raiz . 'php/accion.php';

			$this->cMax=$cMax;
		}
		
		public function buildActionCheckBox($conID)
		{
			?>
				<input type="checkbox" name="conID[]" class="semitrans" value="<?php echo $conID?>" form="acciones<?php echo $this->fId ?>"/>
			<?php
		}
		public function buildFID()
		{
			if(isset($this->fId))
			{
				$this->fNom=$this->fId;
			}
			else
			{
				if(!isset($this->fNom))
				{
					$this->fNom='';
				}
			}
			if(!isset($this->fType))
			{
				$this->fType=$this->fNom;
			}
		}
		public function buildActionForm($conID=NULL , $tNom=NULL, $orden=false)
		{
			$this->buildFID();

			$nArgs=func_num_args();
			if($nArgs>1 && $orden!==NULL)
			{
				?>
					<div class="sep"></div>
				<?php
			}
			?>
				<form 
					<?php
					 	if(isset($this->fId))
					 	{
					 		?>
					 			id="acciones<?php echo $this->fId?>"
					 		<?php
					 	}
					 	/*
					 	else
					 	{
					 		if(!$nArgs===1)
					 		{
						 		?>
						 			class="sinId"
						 		<?php
						 	}
					 	}
					 	*/
					 	if($nArgs===1)
					 	{
					 		?>
					 			class="nCon"
					 		<?php
					 	}
					 	if($nArgs===3)
					 	{
					 		?>
					 			class="right"
					 		<?php
					 	}
					 ?>
					method="POST" action="<?php echo $this->actionUrl ?>"
				>
				<input type="hidden" name="form" value="<?php echo 'acciones'.$this->fType ?>" >
				<?php
				if($nArgs!==1 && $orden!==NULL)
				{
					?>
						<p class="acciones">
							<?php
								if(!$nArgs)
								{
									?>
										Selecci&oacute;n:
									<?php
								}
							?>
							<input type="submit" name="elimina" class="elimina" value="Eliminar">
							<input type="submit" name="edita" class="edita" value="Editar">
						</p>
					<?php
				}
				//Los botones editar y eliminar de las secciones/contenidos/textos.
				if($nArgs===3)
				{
					?>
						<input type="hidden" name="Tipo" value="<?php echo $tNom ?>"/>
						<input type="hidden" name="Orden" value="<?php echo $orden ?>"/>
					<?php
				}
				if($nArgs)
				{
					?>
						<input type="hidden" name="conID" value="<?php echo $conID ?>"/>
					<?php
				}
				if($this->cMax!==0)
				{
				$submitTxt='Nuevo';

				?>
					<p class="acciones">
						<?php
							if(!$nArgs)
							{
								?>
									Acciones:
								<?php
							}
							//Los botones nuevo contenido/texto para las secciones.
							if($nArgs===1)
							{
								?>
									<select name="Tipo">
										<option value="con">Texto</option>
										<option value="inc">Modulo</option>
									</select>
								<?php
							}
							if($this->cMax>1)
							{
								$submitTxt.='s';
								?>
								<select name="cantidad">
									<?php
										for($i=0;$i<$this->cMax;$i++)
										{
											?>
											<option value="<?php echo $i+1 ?>"><?php echo $i+1 ?></option>
											<?php
										}
									?>
								</select>
								<?php
							}
							if($nArgs===3 && $conID===NULL)
							{
								$submitTxt='+';
							}
						?>
						<input type="submit" name="nuevo" class="nuevo" value="<?php echo $submitTxt?>">
					</p>
				<?php 
				} 
				?>
			</form>
		<?php
		}
	}
?>