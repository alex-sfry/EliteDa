<?php

namespace app\services;

use app\models\ar\Markets;
use app\models\ar\ShipModules;
use app\models\ar\Shipyard;
use app\models\ar\Stations;
use app\traits\StationConditionsTrait;
use WpOrg\Requests\Exception\InvalidArgument;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

use function app\helpers\d;

class StationsService
{
    use StationConditionsTrait;

    public ?array $form = null;

    public function __construct(array $form = null)
    {
        $this->form = $form;
    }

    public function findStationsByName(): ActiveQuery
    {
        return Stations::find()
            ->select([
                'stations.*',
                "IF(type!='Outpost','L','M') as pad",
                "IF(type IN ('Planetary Outpost', 'Planetary Port', 'Odyssey Settlement'),TRUE,FALSE) as surface"
            ])
            ->byName($this->form['stName'])
            ->with('system');
    }

    public function findStations(): ActiveQuery
    {
        $expr = (new SystemsService())->distanceExpr($this->form['refSystem']);

        $expr2 = new Expression(
            'CASE WHEN type=Outpost THEN M ELSE L'
        );

        $query = Stations::find()
            ->select([
                'stations.*',
                "IF(type!='Outpost','L','M') as pad",
                "IF(type IN ('Planetary Outpost', 'Planetary Port', 'Odyssey Settlement'),TRUE,FALSE) as surface",
                'faction_name',
                'economy_name',
                "$expr as distance",
                'systems.name as system',
                'systems.id as system_id'
            ])
            ->genericJoin()
            ->innerJoinWith('system')
            ->filter(array_slice($this->form, 1, null, true));

        return $query;
    }

    /**
     * @throws InvalidArgument
     */
    public function getStationServices(int $market_id): array
    {
        !$market_id && throw new InvalidArgument();
        $market_id = (int)$market_id;

        $services = [];
        $services['market'] = Markets::find()
            ->where(['market_id' => $market_id])
            ->cache(3600)
            ->count();

        $services['outfitting'] = ShipModules::find()
            ->where(['market_id' => $market_id])
            ->cache(3600)
            ->count();

        $services['ships'] = Shipyard::find()
            ->where(['market_id' => $market_id])
            ->cache(3600)
            ->count();

        return $services;
    }

    public function systemStation(string $sys_st): Query
    {
        return (new Query())->from('stations')
            ->innerJoin('systems', 'stations.system_id = systems.id')
            ->where(['like', 'stations.name', "$sys_st%", false]);
    }
}
