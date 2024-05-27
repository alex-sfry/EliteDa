<?php

namespace app\models\search;

use app\behaviors\SystemBehavior;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use app\models\views\StationsInfoView;
use yii\helpers\ArrayHelper;

use function app\helpers\d;

/**
 * StationsInfoSearch represents the model behind the search form of `app\models\ar\StationsInfoView`.
 */
class StationsInfoSearch extends StationsInfoView
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [SystemBehavior::class]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            // [['distance_to_arrival'], 'integer'],
            [
                [
                    'station',
                    'system',
                    'type',
                    'government',
                    'economy_name',
                    'allegiance'
                ],
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
    public function search(array $params, int|null $max_distance, string $ref_sys_name)
    {
        extract($this->getCoords($ref_sys_name));
        $distance_expr = new Expression(
            "ROUND(SQRT(POW((x - $x), 2) + POW((y - $y), 2) + POW((z - $z), 2)), 2)"
        );

        $query = StationsInfoView::find()
            ->select([
                '*',
                "$distance_expr as distance",
            ]);

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

        /* grid filtering conditions */
        // $query->andFilterWhere([
        //     'distance_to_arrival' => $this->distance_to_arrival,
        // ]);

        $query
            ->andFilterWhere(['like', 'station', $this->station])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'government', $this->government])
            ->andFilterWhere(['like', 'system', $this->getAttribute('systeme')])
            ->andFilterWhere(['like', 'economy_name', $this->getAttribute('economy_name')])
            ->andFilterWhere(['like', 'allegiance', $this->getAttribute('allegiance')]);

        return $dataProvider;
    }
}
