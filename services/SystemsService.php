<?php

namespace app\services;

use app\models\ar\Systems;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;

class SystemsService
{
    public ?array $form = null;
    public ?ArrayDataProvider $provider = null;

    public function __construct(array $form = null)
    {
        $this->form = $form;
    }

    public function findSystemsByName(): ActiveQuery
    {
        return Systems::find()->byName($this->form['sysName']);
    }

    public function findSystems(): ActiveQuery
    {
        $expr = $this->distanceExpr($this->form['refSystem']);
        $query = Systems::find()
            ->alias('sys')
            ->select([
                'sys.*',
                'faction_name',
                'economy_name',
                'security_level',
                "$expr as distance"
            ])
            ->genericJoin()
            ->filter(array_slice($this->form, 1, null, true));

        return $query;
    }

    public function systemDetails(int $id): ActiveQuery
    {
        return Systems::find()->details((int)$id);
    }

    public function distanceExpr(string $name): Expression
    {
        extract($this->getCoords($name));

        return new Expression("ROUND(SQRT(POW((x - $x), 2) + POW((y - $y), 2) + POW((z - $z), 2)), 2)");
    }

    public function getCoords(string $name): array
    {
        return Systems::find()
            ->coords($name)
            ->asArray()
            ->cache(86400)
            ->one();
    }
}
