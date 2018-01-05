<?php

namespace balitrip\zoo\elements\textfield;

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

	public $value_field = 'value_string';
}