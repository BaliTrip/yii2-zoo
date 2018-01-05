<?php

namespace balitrip\zoo\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class Elements extends \yii\db\ActiveRecord
{

    public $value;

    public function getMultiple() {
        return isset($this->_multiple) ? $this->_multiple : false;
    }

    public static function tableName()
    {
        return '{{%zoo_elements}}';
    }

    public function afterFind()
    {

        if ($this->type !== null  && is_file(Yii::getAlias('@balitrip/zoo').'/elements/'.$this->type.'/Config.php')) {
            $element = '\balitrip\zoo\elements\\'.$this->type.'\Config';
            $this->attachBehaviors([
                $element::className()          // an anonymous behavior
            ]);
        }

        return parent::afterFind();
    }

    public function getFormView() {
        return '@balitrip/zoo/elements/'.$this->type.'/form';
    }

    //related
    public function getRelated() {
        $params = !empty($this->params) ? Json::decode($this->params) : [];
        return !empty($params['related'])?$params['related']:null; 
    }

    public function getParamsArray() {
        return !empty($this->params) ? Json::decode($this->params) : [];
    }

    public function setParamsArray($array) {
        return $this->params = Json::encode($array);
    }

}