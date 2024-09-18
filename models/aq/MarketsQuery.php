<?php

namespace app\models\aq;

use app\traits\StationConditionsTrait;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[Markets]].
 *
 * @see Markets
 */
class MarketsQuery extends \yii\db\ActiveQuery
{
    use StationConditionsTrait;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Markets[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Markets|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function prices(array $form, string $stock_demand, Expression|string $date_sub_expr): ActiveQuery
    {
        return $this
            ->innerJoinWith('station.system')
            ->where(['markets.name' => $form['cMainSelect']])
            ->andFilterCompare('distance_to_arrival', "<={$form['distanceFromStar']}")
            ->andFilterWhere($this->surfaceCondition($form['includeSurface']))
            ->andFilterCompare('type', $this->padCondition($form['landingPadSize']))
            ->andFilterCompare($stock_demand, '>=10')
            ->andFilterCompare($stock_demand, ">={$form['minSupplyDemand']}")
            ->andFilterWhere(['>', 'TIMESTAMP', $date_sub_expr]);
    }
}
