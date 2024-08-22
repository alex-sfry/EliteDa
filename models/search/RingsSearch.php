<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ar\Rings;
use yii\db\Expression;

use function app\helpers\d;

/**
 * RingsSearch represents the model behind the search form of `app\models\ar\Rings`.
 */
class RingsSearch extends Rings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['type', 'distance_to_arrival'],
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
    public function search(array $params, Expression $distance_expr)
    {
        $query = Rings::find();
        $query
            ->select([
                // '*',
                'name',
                'type',
                'reserve',
                'system_name',
                'distance_to_arrival',
                "$distance_expr AS distance"
            ])
            ->where(['not', ['x' => null]])
        ;

        // add conditions that should always apply here

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
        $query
            ->andFilterWhere(['<=', 'distance_to_arrival', $this->distance_to_arrival])
            ->andFilterWhere(['like', 'type', $this->type])
        ;

        $query->cache(7200);

        return $dataProvider;
    }
}
