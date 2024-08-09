<?php

namespace app\controllers;

use app\models\ar\ModulesPriceList;
use app\models\search\ModulesPriceListSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModulesPriceListController implements the CRUD actions for ModulesPriceList model.
 */
class ModulesPriceListController extends Controller
{
    /**
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction(mixed $action): bool
    {
        if (!Yii::$app->user->can('accessAdmin')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
        }

        return parent::beforeAction($action);
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ModulesPriceList models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ModulesPriceListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ModulesPriceList model.
     * @param string $symbol Symbol
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($symbol)
    {
        return $this->render('view', [
            'model' => $this->findModel($symbol),
        ]);
    }

    /**
     * Creates a new ModulesPriceList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ModulesPriceList();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'symbol' => $model->symbol]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ModulesPriceList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $symbol Symbol
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($symbol)
    {
        $model = $this->findModel($symbol);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'symbol' => $model->symbol]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ModulesPriceList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $symbol Symbol
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($symbol)
    {
        $this->findModel($symbol)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ModulesPriceList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $symbol Symbol
     * @return ModulesPriceList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($symbol)
    {
        if (($model = ModulesPriceList::findOne(['symbol' => $symbol])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
