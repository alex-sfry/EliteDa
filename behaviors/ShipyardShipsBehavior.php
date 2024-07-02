<?php

namespace app\behaviors;

use yii\base\Behavior;
use Yii;
use yii\helpers\Json;

class ShipyardShipsBehavior extends Behavior
{
    protected array $shipsReqArr = [
        'cMainSelect' => [],
        'refSystem' => 'Sol',
        'landingPadSize' => 'L',
        'includeSurface' => 'No',
        'maxDistanceFromRefStar' => '50',
        'distanceFromStar' => '500',
        'dataAge' => 'Any',
        'sortBy' => 'Distance',
        'c-form-submit' => ''
        ];

    public function getShipsList(): array
    {
        $arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/ships.json'));
        asort($arr);

        return $arr;
    }

    public function getShipsReqArr(array $params): array
    {
        $this->shipsReqArr['refSystem'] = $params['system'];
        $this->shipsReqArr['cMainSelect'] = $params['ship'];

        return $this->shipsReqArr;
    }
}
