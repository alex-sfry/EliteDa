<?php

namespace app\models\forms;

class ShipyardShipsForm extends \yii\base\Model
{
    public ?string $cMainSelect = '';
    public string $refSystem = '';
    public string $includeSurface = 'No';
    public string $distanceFromStar = '';

    public function rules(): array
    {
        return [
            [['refSystem', 'cMainSelect'], 'required'],
            ['refSystem', 'string', 'length' => [2]],
            [['includeSurface'], 'in', 'range' => ['No', 'Yes', 'Odyssey']],
            [['distanceFromStar'], 'in', 'range' => ['Any', '100', '500', '1000', '2000']],
            [['distanceFromStar'], 'filter', 'filter' => function ($value) {
                return $value === 'Any' ? '' : $value;
            }],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'cMainSelect' => 'Ship',
            'refSystem' => 'Ref. system',
            'includeSurface' => 'Include surface',
            'distanceFromStar' => 'Dist. to arrival',
        ];
    }
}
