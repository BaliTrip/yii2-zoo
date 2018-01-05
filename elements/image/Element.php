<?php

namespace balitrip\zoo\elements\image;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{

	public function rules($attributes)
	{
		return [
			[$attributes,'string'],
			//[$attributes,'required'],
		];
	}

	public $multiple = false;
	public $value_field = 'value_string';

}