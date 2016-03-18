<?php

namespace worstinme\zoo\frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use worstinme\zoo\frontend\models\Items;

/**
 * ItemsSearch represents the model behind the search form about `worstinme\zoo\frontend\models\Items`.
 */
class S extends Items
{
    public $price_min;
    public $price_max;
    public $search;
    public $color;
    public $material;
    public $filter;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_min', 'price_max'], 'integer','min'=>1],
            [['search'], 'safe'],
            [['color'], 'each','rule'=>['string']],
            [['material'], 'each','rule'=>['string']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function query()
    {
        return Items::find()->from(['a'=>'{{%zoo_items}}'])->where(['a.app_id' => $this->app_id ]);
    }

    public function search($params = null)
    {

        if ($params !== null) {
            $this->load($params);
        }

        $query = Items::find()->from(['a'=>'{{%zoo_items}}'])->where(['a.app_id' => $this->app_id ]);

        if ($this->price_max > 0 || $this->price_min > 0) {
            $query->andFilterWhere(['<=','price',$this->price_max]);
            $query->andFilterWhere(['>=','price',$this->price_min]);
        }

        $query->leftJoin(['color'=>'{{%zoo_items_elements}}'], "color.item_id = a.id AND color.element = 'color'");
        $query->leftJoin(['material'=>'{{%zoo_items_elements}}'], "material.item_id = a.id AND material.element = 'material'");

        if ($this->color !== null) {
            $query->andFilterWhere(['color.value_string'=>$this->color]);
        }

        if ($this->material !== null) {
            $query->andFilterWhere(['material.value_string'=>$this->material]);
        }

        return $query;
    }

    public function data($params) {

        $this->load($params);

        $query = $this->search();

        if (!$this->validate()) {
            print_r($this->errors);
           // $query = $this->query();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->groupBy('a.id'),
            'sort'=>[
                'attributes' => [
                    'name' => [
                        'asc' => ['a.name' => SORT_ASC],
                        'desc' => ['a.name' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label'=>'name',
                    ],
                    'price' => [
                        'asc' => ['a.price' => SORT_ASC],
                        'desc' => ['a.price' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label'=>'price',
                    ],
                    'hits' => [
                        'asc' => ['a.hits' => SORT_ASC],
                        'desc' => ['a.hits' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label'=>'hits',
                    ],
                ], 
                'defaultOrder'=>['price' => SORT_DESC],   
            ], 
            'pagination'=>[
                'pageSize'=>30,
            ],
        ]);

        return $dataProvider;
    }
}