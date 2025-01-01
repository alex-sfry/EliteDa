<?php

namespace app\modules\api;

use yii\base\BootstrapInterface;

/**
 * User module Bootstrap class
 */
class ModuleBootstrap implements BootstrapInterface
{
    /**
     * Bootstrap function
     *
     * @param \yii\base\Application $app
     * @return void
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'api' => 'api'
            // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/commodities'],
        ], false);
    }
}
