<?php

namespace app\services;

use app\models\ar\Rings;
use yii\data\ArrayDataProvider;
use yii\data\Sort;

use function app\helpers\d;

class RingsService
{
    public array $form_data;
    public ArrayDataProvider $provider;
    public Sort $sort;

    public function __construct(array $form_data)
    {
        $this->form_data = $form_data;
    }

    public function findRings(): void
    {
        $sortOrders = $this->getSortOrders();

        $this->sort = new Sort([
            'attributes' => [
                'distance',
                'distance_to_arrival'
            ],
            'defaultOrder' => $sortOrders
        ]);

        $rings = Rings::find()
            ->getRingsInRange($this->form_data)
            ->orderBy($this->sort->orders)
            // ->offset(100)
            ->limit(100)
            ->asArray()
            ->cache(86400)
            ->all();

        $this->provider = new ArrayDataProvider([
            'allModels' => $rings,
            'pagination' => [
                'pageSize' => 100,
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
