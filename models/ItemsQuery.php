<?php

namespace worstinme\zoo\models;

class ItemsQuery extends \yii\db\ActiveQuery
{
    public function init()
    {

        $this->from(['i'=>'{{%zoo_items}}'])->with([
            'itemsElements',
            'categories',
        ]);

        parent::init();
    }

}