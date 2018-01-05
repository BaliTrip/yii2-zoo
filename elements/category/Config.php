<?php

namespace balitrip\zoo\elements\category;

use Yii;
use yii\helpers\ArrayHelper;

class Config extends \yii\base\Behavior
{

	public function getParamsView() {
        return '@balitrip/zoo/elements/category/params';
    }
}