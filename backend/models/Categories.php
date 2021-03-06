<?php

namespace balitrip\zoo\backend\models;

use balitrip\zoo\models\Items;
use Yii;
use yii\helpers\Json;

class Categories extends \balitrip\zoo\models\Categories
{
    public function getRelated()
    {
        return $this->hasMany(Categories::className(), ['parent_id' => 'id'])->orderBy('sort ASC');
    } 

    public function getItems()
    {
        return $this->hasMany(Items::className(),['id'=>'item_id'])->viaTable('{{%zoo_items_categories}}',['category_id'=>'id']);
    }

}
