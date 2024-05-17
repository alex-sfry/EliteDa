<?php

namespace app\behaviors;

use app\models\Systems;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class SystemBehavior extends Behavior
{
    /**
     * @param $sys_name
     *
     * @return array
     */
    public function getCoords($sys_name): array
    {
        return ArrayHelper::htmlEncode(Systems::find()
            ->select(['x', 'y', 'z'])
            ->where(['name' => $sys_name])
            ->asArray()
            ->one());
    }
}
