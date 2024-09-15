<?php

namespace app\models\forms;

class StationsNameForm extends \yii\base\Model
{
    public $stName;

    public function rules(): array
    {
        return [
            ['stName', 'required'],
            ['stName', 'string', 'length' => [2]]
        ];
    }

    public function attributeLabels()
    {
        return ['stName' => 'Name'];
    }
}
