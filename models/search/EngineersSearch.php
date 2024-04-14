<?php

namespace app\models\search;

use app\models\Materials;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;

class EngineersSearch extends Model
{
    public $name;
    public $station;
    public $system;
    public $upgrades;
    public $target;
    public $discovery;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'station', 'system', 'target'], 'string'],
            [['upgrades'], 'safe']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return \yii\data\ArrayDataProvider
     */
    public function search(array $params): ArrayDataProvider
    {
        $json = file_get_contents(Yii::$app->basePath . '/data/engineers.json');
        $this->load($params);

        $data = array_filter(Json::decode($json), function ($value) {
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['name'])) {
                return stripos($value['name'], Yii::$app->request->queryParams['EngineersSearch']['name']) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['system'])) {
                return
                    stripos($value['system'], Yii::$app->request->queryParams['EngineersSearch']['system']) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['station'])) {
                return
                  stripos($value['station'], Yii::$app->request->queryParams['EngineersSearch']['station']) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['target'])) {
                return
                    stripos($value['target'], Yii::$app->request->queryParams['EngineersSearch']['target']) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['upgrades'])) {
                return stripos(
                    implode(", ", $value['upgrades']),
                    Yii::$app->request->queryParams['EngineersSearch']['upgrades']
                ) !== false;
            }

            return $value;
        });

        return new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['name', 'station', 'system', 'target']
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
    }
}
