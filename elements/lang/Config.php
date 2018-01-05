<?php

namespace balitrip\zoo\elements\lang;

use Yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class Config extends \yii\base\Behavior
{

    public $iconClass = 'uk-icon-header';

    public function getParamsView() {
        return '@balitrip/zoo/elements/lang/params';
    }

}