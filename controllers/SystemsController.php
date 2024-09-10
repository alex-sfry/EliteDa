<?php

namespace app\controllers;

use app\models\ar\Systems;
use app\models\forms\SystemNameForm;
use app\models\forms\SystemsForm;
use app\services\SystemsService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yiisoft\Arrays\ArrayHelper;

use function app\helpers\d;

class SystemsController extends Controller
{
    public function actionIndex(): string
    {
        $session = Yii::$app->session;
        $request = $this->request;
        $session->open();
        // $session->destroy();

        $sys_name_form = new SystemNameForm();
        $params['sys_name_form'] = $sys_name_form;

        if (!$sys_name_form->load($request->get(), '') || !$sys_name_form->validate()) {
            $params['status'] = $sys_name_form->getErrors();
            return $this->render('index', $params);
        }

        $service = new SystemsService($sys_name_form->attributes);
        $models = $service->findSystem()->all();

        if (!empty([$models])) {
            $params['systems'] = array_chunk($service->findSystem()->all(), 10);
        }

        return $this->render('index', $params);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetails(int $id): string
    {
        $id = (int)$id;
        !$id && throw new NotFoundHttpException();

        $model = Systems::find()
            ->with(['stations', 'economy', 'security', 'allegiance'])
            ->where(['systems.id' => (int)$id])
            ->cache(86400)
            ->asArray()
            ->one();

        !$model && throw new NotFoundHttpException();

        return $this->render('details', [
            'model' => ArrayHelper::htmlEncode($model)
        ]);
    }

    public function actionSystem(string $sys): void
    {
        if (!$sys) {
            throw new NotFoundHttpException();
        } else {
            $data = Systems::find()
                ->select('name as system')
                ->where(['like', 'name', "$sys%", false])
                ->orderBy('name')
                ->cache(86400)
                ->asArray()
                ->all();

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ArrayHelper::htmlEncode($data);

            $response->send();
        }
    }
}
