<?php

namespace app\models\search;

use app\models\ar\Stations;
use app\models\ar\Systems;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;

use function app\helpers\d;

/**
 * This is the search model class for Engineers json data".
 *
 * @property string|null $name
 * @property string|null $station
 * @property string|null $target
 * @property string|null $discovery
 * @property string|null $system
 * @property string|null $upgrades
 */

class EngineersSearch extends Model
{
    protected string $json;
    public $name;
    public $station;
    public $system;
    public $upgrades;
    public $target;
    public $discovery;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->json = file_get_contents(Yii::$app->basePath . '/data/engineers.json');
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'station', 'system'], 'string'],
            [['upgrades'], 'safe']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search(array $params): ArrayDataProvider
    {
        $this->load($params);

        $data = array_filter(Json::decode($this->json), function ($value) {
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['name'])) {
                return stripos($value['name'], $this->name) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['system'])) {
                return
                    stripos($value['system'], $this->system) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['station'])) {
                return
                    stripos($value['station'], $this->station) !== false;
            }
            if (!empty(Yii::$app->request->queryParams['EngineersSearch']['upgrades'])) {
                return stripos(
                    implode(", ", $value['upgrades']),
                    $this->upgrades
                ) !== false;
            }

            return $value;
        });

        $st_sys = $this->getSystemsStationsIds($data);

        foreach ($data as $key => $value) {
            $k = array_search(
                $value['system'],
                array_column($st_sys, 'system_name')
            );

            $data[$key]['system_id'] = $st_sys[$k]['system_id'];
            $data[$key]['station_id'] = $st_sys[$k]['station_id'];
        }

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

    protected function getSystemsStationsIds(array $data): array
    {
        $system_names = array_map(function ($item) {
            return $item['system'];
        }, $data);

        $station_names = array_map(function ($item) {
            return $item['station'];
        }, $data);

        $sys = Systems::find()
            ->select(['id'])
            ->where(['name' => $system_names]);

        return Stations::find()
            ->alias('st')
            ->select([
                'st.id AS station_id',
                'st.name AS station_name',
                'sys.id AS system_id',
                'sys.name AS system_name'
            ])
            ->innerJoin(['sys' => 'systems'], 'sys.id = st.system_id')
            ->where(['st.name' => $station_names, 'st.system_id' => $sys])
            ->asArray()
            ->all();
    }

    public function getName(int $system_id, string $station_name): array
    {
        $system = Systems::findOne($system_id);

        if (!$system) {
            return ['id' => '', 'name' => ''];
        }

        foreach (Json::decode($this->json) as $item) {
            if ($item['station'] === $station_name && $item['system'] === $system->name) {
                return ['id' => $item['id'], 'name' => $item['name']];
            }
        }

        return ['id' => '', 'name' => ''];
    }
}
