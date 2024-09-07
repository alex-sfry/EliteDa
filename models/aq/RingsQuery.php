<?php

namespace app\models\aq;

use app\models\ar\Rings;
use app\models\ar\Systems;
use yii\db\Expression;

use function app\helpers\d;

/**
 * This is the ActiveQuery class for [[Rings]].
 *
 * @see Rings
 */
class RingsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Rings[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     */
    public function one($db = null): Rings|array|null
    {
        return parent::one($db);
    }

    public function getRingsInRange(array $form_data): \yii\db\ActiveQuery
    {
        $coords = Systems::find()
            ->select(['x', 'y', 'z'])
            ->where(['name' => $form_data['refSystem']])
            ->asArray()
            ->one();

        extract($coords);
        $expr = new Expression("ROUND(SQRT(POW((x - $x), 2) + POW((y - $y), 2) + POW((z - $z), 2)), 2)");

        $query = $this
            ->select([
                'name',
                'type',
                'system_name',
                'distance_to_arrival',
                'reserve',
                "$expr as distance"
            ])
            ->where(['type' => $form_data['type']]);
        $form_data['distanceFromStar'] !== 'Any' &&
            $query->andWhere(['<=', 'distance_to_arrival', $form_data['distanceFromStar']]);
        $query->andWhere(['<=', $expr, $form_data['maxDistanceFromRefStar']])->asArray();

        return $query;
    }
}
