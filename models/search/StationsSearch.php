<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ar\Stations;
use yii\db\Expression;

use function app\helpers\d;

/**
 * StationsSearch represents the model behind the search form of `app\models\ar\Stations`.
 */
class StationsSearch extends Stations
{
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'economyId1.economy_name',
            'allegiance.faction_name'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'id',
                    'market_id',
                    'system_id',
                    /* 'distance_to_arrival', */
                    'allegiance_id',
                    'economy_id_1',
                    'economy_id_2'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'type',
                    'government',
                    'sys_name',
                    'economyId1.economy_name',
                    'allegiance.faction_name'
                    /*, 'distance'*/],
                'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search(array $params, int|null $max_distance, Expression $distance_expr)
    {
        // add conditions that should always apply here
        $query = Stations::find()
            ->alias('st')
            ->select([
                'st.name',
                'type',
                'distance_to_arrival',
                'government',
                'economy_id_1',
                'st.allegiance_id',
                "$distance_expr as distance",
                'systems.name as sys_name'
            ])
            ->joinWith(['system', 'economyId1 ec', 'allegiance al'])
            ;

        $max_distance && $query->where(['<=', $distance_expr, $max_distance]);

        // d($query->one());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'market_id' => $this->market_id,
            'system_id' => $this->system_id,
            // 'distance_to_arrival' => $this->distance_to_arrival,
            'allegiance_id' => $this->allegiance_id,
            'economy_id_1' => $this->economy_id_1,
            'economy_id_2' => $this->economy_id_2,
        ]);

        $query->andFilterWhere(['like', 'st.name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'government', $this->government])
            ->andFilterWhere(['like', 'systems.name', $this->getAttribute('sys_name')])
            ->andFilterWhere(['like', 'ec.economy_name', $this->getAttribute('economyId1.economy_name')])
            ->andFilterWhere(['like', 'al.faction_name', $this->getAttribute('allegiance.faction_name')])
            // ->andFilterWhere(['like', "$distance_expr", $this->getAttribute('distance')])
            ;

        return $dataProvider;
    }
}
