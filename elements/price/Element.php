<?php

namespace balitrip\zoo\elements\price;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{

	public function rules($attributes)
	{
		return [
			[$attributes,'number'],
			[$attributes,'required'],
		];
	}

	public $value_field = 'value_float';
}