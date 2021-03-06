<?php

namespace balitrip\zoo\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use balitrip\zoo\backend\models\Menu;

/**
 * MenuSearch represents the model behind the search form about `balitrip\zoo\backend\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'application_id', 'category_id', 'item_id', 'parent_id', 'sort', 'type'], 'integer'],
            [['name', 'url', 'menu'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Menu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'application_id' => $this->application_id,
            'category_id' => $this->category_id,
            'item_id' => $this->item_id,
            'parent_id' => $this->parent_id,
            'sort' => $this->sort,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'menu', $this->menu]);

        return $dataProvider;
    }
}
