<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\CommentModel;
use app\models\ProductModel;

class ReviewController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post'],
                ],
            ],
        ];
    }

    public $defaultAction = 'add';

    public function actionAdd()
    {
        $model = new CommentModel();
        $model->date = date("Y-m-d");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $product = ProductModel::find()->where(['id'=>$model->idProduct])->one();
            $product->rating = (($product->rating * $product->amountRated) + $model->mark ) / ($product->amountRated + 1);
            $product->amountRated = $product->amountRated + 1;
            if (!$product->save())
                echo "Error updating product.";
        }
        else
        {
            echo "Error adding comment.";
        }
        return $this->redirect(\Yii::$app->user->getReturnUrl());
    }
}
