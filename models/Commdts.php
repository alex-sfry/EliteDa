<?php

namespace app\models;

use app\behaviors\CommoditiesBehavior;
use app\behaviors\StationBehavior;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\VarDumper;

class Commdts extends Model
{
    public function behaviors(): array
    {
        return [
            CommoditiesBehavior::class,
            StationBehavior::class
            ];
    }
    public function getPrices($sys_name, $commodities): ActiveDataProvider
    {
        $ref_xyz = $this->getCoords($sys_name);

        $c_symbols = [];

        foreach ($this->getCommodities() as $key => $value) {
            if (in_array($value, $commodities)) {
                $c_symbols[] = $key;
            }
        }

        $prices = (new Query())
            ->select([
                'buy_price',
                'demand',
                'sell_price',
                'stock',
                'm.name AS commodity',
                'st.name AS station',
                'type',
                'distance_to_arrival AS distance_ls',
                'sys.name AS system',
                "ROUND(SQRT(POW((sys.x - {$ref_xyz['x']}), 2) + POW((sys.y - {$ref_xyz['y']}), 2) + 
                POW((sys.z - {$ref_xyz['z']}), 2)), 2) AS distance_ly",
                'TIMESTAMPDIFF(SECOND, TIMESTAMP, NOW()) as time_diff'
            ])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['m.name' => $c_symbols])
            ->andWhere([
                '<=',
                "ROUND(SQRT(POW((sys.x - {$ref_xyz['x']}), 2) + POW((sys.y - {$ref_xyz['y']}), 2) + 
                POW((sys.z - {$ref_xyz['z']}), 2)), 2)",
                50,
            ]);

        return  new ActiveDataProvider(config: [
            'query' => $prices,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly'
                ],
                'defaultOrder' => [
                        'distance_ly' => SORT_DESC,
                ],
            ]
        ]);
    }

    public function modifyModels($models): array
    {
        foreach ($models as $key => $value) {
        }
        return [];
    }

    public function getCoords($sys_name): array
    {
        return Systems::find()
            ->select(['x', 'y', 'z'])
            ->where(['name' => $sys_name])
            ->asArray()
            ->one();
    }
}
