<?php

namespace balitrip\zoo\elements\related;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{

	public function rules($attributes)
	{
		return [
			[$attributes,'integer'],
		];
	}

    public $value_field = 'value_int';

}