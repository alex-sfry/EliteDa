<?php

namespace app\services;

use app\models\ar\Rings;
use yii\data\ArrayDataProvider;

use function app\helpers\d;

class RingsService
{
    public array $form_data;
    public ArrayDataProvider $provider;
    // public Sort $sort;

    public function __construct(array $form_data)
    {
        $this->form_data = $form_data;
    }

    public function findRings(): void
    {
        $rings = Rings::find()
            ->getRingsInRange($this->form_data)
            ->orderBy('distance')
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
}
