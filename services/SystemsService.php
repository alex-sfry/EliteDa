<?php

namespace app\services;

use app\models\search\SystemsInfoSearch;
use yii\data\ActiveDataProvider;

use function app\helpers\d;

class SystemsService
{
    public ?array $form_data = null;
    public ?ActiveDataProvider $provider = null;
    public ?SystemsInfoSearch $searchModel = null;
    public array $queryParams = [];

    public function __construct(array $form_data)
    {
        $this->form_data = $form_data;
    }

    public function findSystems(array $queryParams): void
    {
        $this->searchModel = new SystemsInfoSearch();
        $this->provider = $this->searchModel->search(
            $queryParams,
            $this->form_data['maxDistanceFromRefStar'],
            $this->form_data['refSystem']
        );
        $this->provider->pagination->defaultPageSize = 50;
        $this->provider->pagination->forcePageParam = false;
        $this->provider->pagination->pageSize = null;

        $this->provider->sort->attributes['distance'] = [
            'asc' => ['distance' => SORT_ASC],
            'desc' => ['distance' => SORT_DESC],
        ];

        $this->provider->sort->defaultOrder = [
            'distance' => SORT_ASC
        ];

        if (empty($queryParams) || !isset($queryParams['SystemsInfoSearch'])) {
            $this->queryParams['SystemsInfoSearch'] = array_fill_keys(
                array_values($this->searchModel->activeAttributes()),
                null
            );
        } else {
            $this->queryParams = $queryParams;
        }
    }
}
