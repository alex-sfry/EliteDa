<?php

namespace app\models\search;

use app\models\ar\MaterialTraders;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MaterialTradersSearch represents the model behind the search form of `app\models\MaterialTraders`.
 */
class MaterialTradersSearch extends MaterialTraders
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['material_type'], 'safe'],
            [['id', 'system_id', 'station_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search(array $params, $distance_expr): ActiveDataProvider
    {
        $query = MaterialTraders::find();

        // add conditions that should always apply here
        $query
            ->select([
                '*',
                "$distance_expr AS distance"
            ])
            ->innerJoinWith(['system', 'station']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'material_type', $this->material_type]);

        return $dataProvider;
    }
}
