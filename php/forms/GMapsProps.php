<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/Separatable.php';

	class GMapsProps extends Separatable
	{
		public $props;
		public $propsLen;

		public function __construct($separator)
		{
			parent::__construct($separator);

			$this->props=[];
			$this->propsLen=0;
		}
		public function add($prop)
		{
			$this->props[$this->propsLen]=$prop;

			++$this->propsLen;

			return $this;
		}
		public function encode()
		{
			$buff='';

			$propsLen=$this->propsLen;

			for($i=0;$i<$propsLen;$i++)
			{
				$prop=$this->props[$i];

				if(gettype($prop)==='object')
				{
					$prop=$prop->encode();
				}

				$buff=$buff.$prop;

				if($i!==$propsLen-1)
				{
					$this->addSeparatorTo($buff);
				}
			}

			return $buff;
		}
	}
?>