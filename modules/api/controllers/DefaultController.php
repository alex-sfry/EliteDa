<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;

use function app\helpers\d;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
