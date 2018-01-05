<?php

namespace balitrip\zoo\elements\textarea;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{

	public function rules($attributes)
	{
		return [
			[$attributes,'safe'],
			//[$attributes,'required'],
		];
	}
}