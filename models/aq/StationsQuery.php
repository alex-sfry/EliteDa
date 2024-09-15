<?php

namespace app\models\aq;

use app\traits\StationConditionsTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Stations]].
 *
 * @see Stations
 */
class StationsQuery extends \yii\db\ActiveQuery
{
    use StationConditionsTrait;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Stations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Stations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function generic(): ActiveQuery
    {
        return $this->with('allegiance', 'economyId1');
    }

    public function genericJoin(): ActiveQuery
    {
        return $this->innerJoinWith('allegiance')
            ->innerJoinWith('economyId1');
    }

    public function byName(string $name): ActiveQuery
    {
        return $this->generic()->andWhere(['like', 'stations.name', "$name%", false]);
    }

    public function details(int $id): ActiveQuery
    {
        return $this->generic()->with('system')->andWhere(['systems.id' => $id]);
    }

    public function filter(array $conditions): ActiveQuery
    {
        return $this->andFilterCompare('distance_to_arrival', "<={$conditions['dta']}")
            ->andFilterCompare('government', $conditions['government'])
            ->andFilterCompare('faction_name', $conditions['allegiance'])
            ->andFilterCompare('economy_name', $conditions['economy'])
            ->andFilterCompare('type', $this->padCondition($conditions['pad']))
            ->andFilterWhere($this->surfaceCondition($conditions['inclSurface']));
    }
}
