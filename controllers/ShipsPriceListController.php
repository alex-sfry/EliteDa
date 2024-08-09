<?php

namespace app\controllers;

use app\models\ar\ShipsPriceList;
use app\models\search\ShipsPriceListSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShipsPriceListController implements the CRUD actions for ShipsPriceList model.
 */
class ShipsPriceListController extends Controller
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
     * Lists all ShipsPriceList models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShipsPriceListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShipsPriceList model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    /**
     * Creates a new ShipsPriceList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ShipsPriceList();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'name' => $model->name]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ShipsPriceList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ShipsPriceList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShipsPriceList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return ShipsPriceList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = ShipsPriceList::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
