<?php

namespace app\services;

use app\models\ar\Rings;
use yii\data\ActiveDataProvider;

use function app\helpers\d;

class RingsService
{
    public array $form_data;
    public ActiveDataProvider $provider;

    public function __construct(array $form_data)
    {
        $this->form_data = $form_data;
    }

    public function findRings(): void
    {
        $rings = Rings::find()
            ->getRingsInRange($this->form_data);

        $sortOrders = $this->getSortOrders();

        $this->provider = new ActiveDataProvider([
            'query' => $rings/* ->cache(86400) */,
            'sort' => [
                'attributes' => [
                    'distance_to_arrival',
                    'distance',
                ],
                'defaultOrder' => $sortOrders
            ],
            'pagination' => [
                'pageSize' => 25,
                'pageSizeParam' => false
            ],
        ]);
    }

    public function postprocessData(array $rings): array
    {
        foreach ($rings as $key => $value) {
            $rings[$key]['reserve'] = str_replace('Resources', '', $value['reserve']);
        }

        return $rings;
    }

    private function getSortOrders(): array
    {
        if ($this->form_data['sortBy'] === 'DistanceLs') {
            return ['distance_to_arrival' => SORT_ASC];
        } elseif ($this->form_data['sortBy'] === 'DistanceLy') {
            return ['distance' => SORT_ASC];
        }
    }
}
