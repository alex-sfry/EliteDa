<?php

namespace app\behaviors;

use yii\base\Behavior;
use Yii;
use yii\helpers\Json;

class ShipyardShipsBehavior extends Behavior
{
    private array $shipsReqArr = [
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

    /**
     * @return array
     */
    public function getShipsList(): array
    {
        $arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/ships.json'));
        asort($arr);

        return $arr;
    }

    /**
     * @var array $params
     *
     * @return array
     */
    public function getShipsReqArr(array $params): array
    {
        $this->shipsReqArr['refSystem'] = $params['system'];
        $this->shipsReqArr['cMainSelect'] = $params['ship'];

        return $this->shipsReqArr;
    }
}
