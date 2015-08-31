<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';

	class RadioNov extends FormImgRadio
	{
		function __construct($parentForm , $name , $value)
		{
			parent::__construct($parentForm , $name , $value);

			$this->setCol
			(
				[
					'xs'=>3,
					'sm'=>3,
					'md'=>3,
					'lg'=>3
				]
			)->classList->add('radioImgNov');

			$this->input->setCol
			(
				[
					'xs'=>12,
					'sm'=>12,
					'md'=>12,
					'lg'=>12
				]
			);
		}
		function setImgSrc($imgSrc)
		{
			parent::setImgSrc($imgSrc);

			$this->img->setCol
			(
				[
					'xs'=>12,
					'sm'=>12,
					'md'=>12,
					'lg'=>12
				]
			);

			return $this;
		}
	}
?>