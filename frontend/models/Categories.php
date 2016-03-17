<?php

namespace worstinme\zoo\frontend\models;

use Yii;
use yii\helpers\Json;

class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zoo_categories}}';
    }

    public function getApp() {
        return $this->hasOne(Applications::className(),['id'=>'app_id']);
    }

    public function getParent() {
        return $this->hasOne(Categories::className(),['id'=>'parent_id']);
    }

    //metaTitle
    public function getMetaTitle() {
        $params = $this->params !== null ? Json::decode($this->params) : null;
        return isset($params['metaTitle']) ? $params['metaTitle'] : '';
    }

    //metaKeywords
    public function getMetaKeywords() {
        $params = $this->params !== null ? Json::decode($this->params) : null;
        return isset($params['metaKeywords']) ? $params['metaKeywords'] : '';
    }

    //metaDescription
    public function getMetaDescription() {
        $params = $this->params !== null ? Json::decode($this->params) : null;
        return isset($params['metaDescription']) ? $params['metaDescription'] : '';
    }

    //metaDescription
    public function getContent() {
        $params = $this->params !== null && !empty($this->params) ? Json::decode($this->params) : [];
        return isset($params['content']) ? $params['content'] : '';
    }

    //metaDescription
    public function getPreContent() {
        $params = $this->params !== null && !empty($this->params) ? Json::decode($this->params) : [];
        return isset($params['preContent']) ? $params['preContent'] : '';
    }

    public function getUrl() {

        $a = $this->app->name;

        if ($this->parent !== null) {
            if ($this->parent->parent !== null) {
                return ['/zoo/default/abcd','a'=>$a,'b'=>$this->parent->parent->alias,'c'=>$this->parent->alias,'d'=>$this->alias];
            }
            else {
                return ['/zoo/default/abc','a'=>$a,'b'=>$this->parent->alias,'c'=>$this->alias];
            }
        }
        else {
            return ['/zoo/default/ab','a'=>$a,'b'=>$this->alias];
        }

    }
}
