<?php

namespace app\models\aq;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Shipyard]].
 *
 * @see Shipyard
 */
class ShipyardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Shipyard[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Shipyard|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function ships(string $ship): ActiveQuery
    {
        return $this
            ->innerJoinWith('station.system')
            ->where(['shipyard.name' => $ship]);
    }

    public function stationShips(int $market_id): ActiveQuery
    {
        return $this
            ->select([
                'sprc.name',
                'slst.symbol',
                'price',
                'timestamp',
            ])
            ->innerJoin(['slst' => 'ships_list'], 'slst.symbol = shipyard.name')
            ->innerJoin(['sprc' => 'ships_price_list'], 'sprc.name = slst.name')
            ->where(['market_id' => $market_id])
            ->orderBy('sprc.name');
    }

    public function filter(array $conditions): ActiveQuery
    {
        return $this
            ->andFilterCompare('distance_to_arrival', "<={$conditions['distanceFromStar']}")
            ->andFilterWhere($conditions['surface']);
    }
}
