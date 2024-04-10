<?php

namespace app\models\search;

use app\models\MaterialTraders;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

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
    public function search(array $params, $refCoords): ActiveDataProvider
    {
        extract($refCoords);
        $query = MaterialTraders::find();

        // add conditions that should always apply here
        $query
            ->select([
                '*',
                new Expression(
                    "ROUND(SQRT(POW((systems.x - $x), 2) + POW((systems.y - $y), 2) +
                    POW((systems.z - $z), 2)), 2) AS distance"
                ),
            ])
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
            'distance' => $this->distance,
        ]);

        $query->andFilterWhere(['like', 'material_type', $this->material_type]);

        return $dataProvider;
    }
}
