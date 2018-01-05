<?php

namespace balitrip\zoo\elements\select;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{
    public $value_field = 'value_int';

	public function rules($attributes)
	{
		return [
			[$attributes,'string'],
		];
	}

}