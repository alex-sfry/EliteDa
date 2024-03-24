<?php

namespace app\behaviors;

use app\models\Systems;
use yii\base\Behavior;

class SystemBehavior extends Behavior
{

    /**
     * @param $sys_name
     *
     * @return array
     */
    public function getCoords($sys_name): array
    {
        return Systems::find()
            ->select(['x', 'y', 'z'])
            ->where(['name' => $sys_name])
            ->asArray()
            ->one();
    }
}
