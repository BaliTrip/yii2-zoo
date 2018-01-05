<?php

namespace balitrip\zoo\elements\name;

use Yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class Config extends \yii\base\Behavior
{

    public $iconClass = 'uk-icon-header';

    public function init() {

        parent::init();

    }

    public function getParamsView() {
        return '@balitrip/zoo/elements/name/params';
    }


}