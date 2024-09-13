<?php

namespace app\models\aq;

use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[Systems]].
 *
 * @see Systems
 */
class SystemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Systems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Systems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function generic(): ActiveQuery
    {
        return $this->with('allegiance', 'economy', 'security');
    }

    public function genericJoin(): ActiveQuery
    {
        return $this->innerJoinWith('allegiance')
            ->innerJoinWith('economy')
            ->innerJoinWith('security');
    }

    public function byName(string $name): ActiveQuery
    {
        return $this->genericJoin()->andWhere(['like', 'name', "$name%", false]);
    }

    public function details(int $id): ActiveQuery
    {
        return $this->generic()->with('stations')->andWhere(['systems.id' => $id]);
    }

    public function filter(array $conditions): ActiveQuery
    {
        return $this->andFilterCompare('population', ">={$conditions['population']}")
            ->andFilterCompare('faction_name', $conditions['allegiance'])
            ->andFilterCompare('economy_name', $conditions['economy'])
            ->andFilterCompare('security_level', $conditions['security']);
    }

    public function coords(string $name): ActiveQuery
    {
        return $this->select(['x', 'y', 'z'])->where(['name' => $name]);
    }
}
