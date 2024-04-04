<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MaterialTraders;

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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = MaterialTraders::find();

        // add conditions that should always apply here
        $query
            ->innerJoinWith('system')
            ->innerJoinWith('station');

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
        $query->andFilterWhere([
            'id' => $this->id,
            'system_id' => $this->system_id,
            'station_id' => $this->station_id,
        ]);

        $query->andFilterWhere(['like', 'material_type', $this->material_type]);
//        $query->andFilterWhere(['like', 'systems.name', 'systems.name']);

        return $dataProvider;
    }
}
