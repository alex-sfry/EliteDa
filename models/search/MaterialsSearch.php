<?php

namespace app\models\search;

use app\models\ar\Materials;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MaterialsSearch represents the model behind the search form of `app\models\Materials`.
 */
class MaterialsSearch extends Materials
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'category', 'grade', 'type'], 'string'],
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
    public function search(array $params): ActiveDataProvider
    {
        $query = Materials::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->getAttribute('name')])
            ->andFilterWhere(['like', 'category', $this->getAttribute('category')])
            ->andFilterWhere(['like', 'grade', "{$this->getAttribute('grade')}%", false])
            ->andFilterWhere(['like', 'type', $this->getAttribute('type')]);

        return $dataProvider;
    }
}
