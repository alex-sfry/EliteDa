<?php

namespace app\models;

use app\entities\Engineer;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use function app\helpers\d;

class Engineers extends Model
{
    protected array $engineers;
    protected array $engineers_arr;

    public function init()
    {
        $this->engineers_arr = Json::decode(file_get_contents(Yii::$app->basePath . '/data/engineers.json'));
    }

    protected function getEngineer(): Engineer
    {
        return new Engineer();
    }

    public function getEngineers(): array
    {
        return $this->engineers;
    }

    public function findById(int $id): Engineers
    {
        $engineer_props = array_filter($this->engineers_arr, function ($value) use ($id) {
            return $value['id'] === $id;
        })[0];

        $engineer = $this->getEngineer();

        foreach ($engineer_props as $key => $value) {
            $engineer->$key = property_exists($this->engineers_arr, $key) ? $value : null;
        }

        $this->engineers = $engineer;

        return $this;
    }

    public function findByUpgrade(string $upgrade): Engineers
    {
        $filtered_engineers = array_filter($this->engineers_arr, function ($value) use ($upgrade) {
            return ArrayHelper::isIn($upgrade, $value['upgrades']);
        });

        foreach ($filtered_engineers as $item) {
            $engineer = $this->getEngineer();

            foreach ($item as $key => $value) {
                $engineer->$key = property_exists($engineer, $key) ? $value : null;
            }

            $this->engineers[] = $engineer;
        }

        return $this;
    }

    public function findByName(string $name): Engineers
    {
        $filtered_engineers = array_filter($this->engineers_arr, function ($value) use ($name) {
            return stripos($value['name'], $name) !== false;
        });

        foreach ($filtered_engineers as $item) {
            $engineer = $this->getEngineer();

            foreach ($item as $key => $value) {
                $engineer->$key = property_exists($engineer, $key) ? $value : null;
            }

            $this->engineers[] = $engineer;
        }

        return $this;
    }
}
