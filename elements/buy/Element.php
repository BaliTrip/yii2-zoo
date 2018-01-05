<?php

namespace balitrip\zoo\elements\buy;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{

	public function rules($attributes)
	{
		return [ ];
	}

	public function getValue($attribute) {
    	return true;
    }
}