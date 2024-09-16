<?php

namespace app\traits;

use Yii;
use yii\helpers\Json;

trait ShipyardShipsTrait
{
    private array $shipsReqArr = [
        'cMainSelect' => '',
        'refSystem' => 'Sol',
        'includeSurface' => 'No',
        'distanceFromStar' => 'Any',
        'formBtn' => ''
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
