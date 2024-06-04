<?php

namespace app\behaviors;

use app\models\ar\Systems;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class SystemBehavior extends Behavior
{
    public function getCoords(string $sys_name): array
    {
        return ArrayHelper::htmlEncode(Systems::find()
            ->select(['x', 'y', 'z'])
            ->where(['name' => $sys_name])
            ->asArray()
            ->one());
    }

    public function getDistanceToSystemExpression(string $sys_name, array $coords = [])
    {
        if (count($coords) === 3) {
            extract($coords);
        } else {
            extract($this->getCoords($sys_name));
        }

        return new Expression(
            "ROUND(SQRT(POW((systems.x - $x), 2) + POW((systems.y - $y), 2) +
            POW((systems.z - $z), 2)), 2)"
        );
    }
}
