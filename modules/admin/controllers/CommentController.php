<?php

namespace app\modules\admin\controllers;
use yii\filters\AccessControl;

use Yii;
use app\models\CommentModel;
use app\models\ProductModel;
use app\models\CommentSearch;
use app\modules\admin\controllers\DefaultController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for CommentModel model.
 */
class CommentController extends DefaultController
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
     * Lists all CommentModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CommentModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CommentModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommentModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $product = ProductModel::find()->where(['id'=>$model->idProduct])->one();
            $product->rating = (($product->rating * $product->amountRated) + $model->mark ) / ($product->amountRated + 1);
            $product->amountRated = $product->amountRated + 1;
            $product->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CommentModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mark = $model->mark;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $product = ProductModel::find()->where(['id'=>$model->idProduct])->one();
            $product->rating = (($product->rating * $product->amountRated) - $mark + $model->mark) / $product->amountRated;
            $product->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CommentModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $product = ProductModel::find()->where(['id'=>$model->idProduct])->one();
        if ($product->amountRated > 1)
            $product->rating = (($product->rating * $product->amountRated) - $model->mark) / ($product->amountRated - 1);
        else
            $product->rating = 0;
        $product->amountRated = $product->amountRated - 1;
        $product->save();

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CommentModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CommentModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommentModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
