<?php

namespace app\models\aq;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ShipModules]].
 *
 * @see ShipModules
 */
class ShipModulesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ShipModules[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ShipModules|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function modules(array $module): ActiveQuery
    {
        return $this
            ->innerJoinWith('station.system')
            ->where(['ship_modules.name' => $module]);
    }

    public function filter(array $conditions): ActiveQuery
    {
        return $this
            ->andFilterCompare('distance_to_arrival', "<={$conditions['distanceFromStar']}")
            ->andFilterWhere($conditions['surface'])
            ->andFilterCompare('type', $conditions['pad']);
    }

    public function armour(int $market_id): ActiveQuery
    {
        return $this->select(['category', 'ship_modules.name'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'standard'])
            ->andWhere(['like', 'ship_modules.name', 'Armour']);
    }

    public function hardpoint(int $market_id): ActiveQuery
    {
        return $this->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'hardpoint']);
    }

    public function core(int $market_id): ActiveQuery
    {
        return $this->select(['category', 'ship_modules.name'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'standard'])
            ->andWhere(['not like', 'ship_modules.name', '_Armour_']);
    }

    public function internal(int $market_id): ActiveQuery
    {
        return $this->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'internal']);
    }

    public function utility(int $market_id): ActiveQuery
    {
        return $this->select(['category'])
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->where(['market_id' => $market_id])
            ->andWhere(['category' => 'utility']);
    }

    public function stationModules(int $market_id, string $cat): ActiveQuery
    {
        return $this
            ->innerJoin(['mlst' => 'ship_modules_list'], 'mlst.symbol = ship_modules.name')
            ->innerJoin(['mprc' => 'modules_price_list'], 'mprc.symbol = ship_modules.name')
            ->andWhere(['market_id' => $market_id])
            ->filterStationModules($cat);
    }

    public function filterStationModules(string $cat): ActiveQuery
    {
        $query = $this;

        switch ($cat) {
            case 'armour':
                $this->andWhere(['category' => 'standard'])->andWhere(['like', 'ship_modules.name', 'Armour']);
                break;
            case 'core':
                $this->andWhere(['category' => 'standard'])->andWhere(['not like', 'ship_modules.name', '_Armour_']);
                break;
            case 'internal':
                $this->andWhere(['category' => 'internal']);
                break;
            case 'utility':
                $this->andWhere(['category' => 'utility']);
                break;
            case 'hardpoint':
                $this->andWhere(['category' => 'hardpoint']);
                break;
            default:
                $this->andWhere(['category' => 'hardpoint']);
        };

        return $query;
    }
}
