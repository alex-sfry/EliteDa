<?php

namespace app\models\search;

use app\behaviors\SystemBehavior;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use app\models\views\SystemsInfoView;
use yii\helpers\ArrayHelper;

use function app\helpers\d;

/**
 * SystemsInfoSearch represents the model behind the search form of `app\models\views\SystemsInfoView`.
 */
class SystemsInfoSearch extends SystemsInfoView
{
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
            [['id', 'population'], 'integer'],
            [['system', 'security', 'allegiance', 'economy'], 'string'],
            // [['distance'], 'number']
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
     */
    public function search(array $params, int|null $max_distance, string $ref_sys_name): ActiveDataProvider
    {
        /** @var SystemBehavior|SystemsInfoSearch $this */

        extract($this->getCoords($ref_sys_name));
        $distance_expr = new Expression(
            "ROUND(SQRT(POW((x - $x), 2) + POW((y - $y), 2) + POW((z - $z), 2)), 2)"
        );

        $query = SystemsInfoView::find()
            ->select([
                '*',
                "$distance_expr as distance",
            ]);

        $max_distance && $query->where(['<=', $distance_expr, $max_distance]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /* grid filtering conditions */
        $query
            ->andFilterWhere(['>=','population', $this->getAttribute('population')])
            ->andFilterWhere(['like', 'system', $this->getAttribute('system')])
            ->andFilterWhere(['like', 'security', $this->getAttribute('security')])
            ->andFilterWhere(['like', 'economy', $this->getAttribute('economy')])
            ->andFilterWhere(['like', 'allegiance', $this->getAttribute('allegiance')]);

        $query->cache(86400);

        return $dataProvider;
    }
}
