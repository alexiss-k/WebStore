<?php

namespace app\modules\admin\controllers;
use yii\filters\AccessControl;

use Yii;
use app\models\CharacteristicValueModel;
use app\models\CharacteristicValueSearch;
use app\modules\admin\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharacteristicValueController implements the CRUD actions for CharacteristicValueModel model.
 */
class CharacteristicValueController extends DefaultController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete'],
                        'roles' => ['administrator'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CharacteristicValueModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharacteristicValueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CharacteristicValueModel model.
     * @param integer $idProduct
     * @param integer $idCharacteristic
     * @return mixed
     */
    public function actionView($idProduct, $idCharacteristic)
    {
        return $this->render('view', [
            'model' => $this->findModel($idProduct, $idCharacteristic),
        ]);
    }

    /**
     * Creates a new CharacteristicValueModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CharacteristicValueModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idProduct' => $model->idProduct, 'idCharacteristic' => $model->idCharacteristic]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CharacteristicValueModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idProduct
     * @param integer $idCharacteristic
     * @return mixed
     */
    public function actionUpdate($idProduct, $idCharacteristic)
    {
        $model = $this->findModel($idProduct, $idCharacteristic);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idProduct' => $model->idProduct, 'idCharacteristic' => $model->idCharacteristic]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CharacteristicValueModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idProduct
     * @param integer $idCharacteristic
     * @return mixed
     */
    public function actionDelete($idProduct, $idCharacteristic)
    {
        $this->findModel($idProduct, $idCharacteristic)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CharacteristicValueModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idProduct
     * @param integer $idCharacteristic
     * @return CharacteristicValueModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idProduct, $idCharacteristic)
    {
        if (($model = CharacteristicValueModel::findOne(['idProduct' => $idProduct, 'idCharacteristic' => $idCharacteristic])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
