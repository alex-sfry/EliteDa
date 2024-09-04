<?php

namespace app\models\aq;

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
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Rings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
