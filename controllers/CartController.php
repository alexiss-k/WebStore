<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\models\ProductModel;

class CartController extends Controller
{

    public $defaultAction = 'view';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-item' => ['post'],
                ],
            ],
        ];
    }

    public function actionView()
    {
        $cart_info = \Yii::$app->request->cookies->getValue('cart');
        $cart_info = unserialize($cart_info);
        print_r($cart_info);
    }

    public function actionAddItem($id)
    {
        $added = false;
        $cart_info = \Yii::$app->request->cookies->getValue('cart');
        if ($cart_info !== null) {
            $cart_info = unserialize($cart_info);
            if (is_array($cart_info)) {
                foreach ($cart_info as $product_id => &$quantity)
                {
                    if ($id == $product_id) {
                        $quantity++;
                        $added = true;
                        break;
                    }
                }

                if (!$added) {
                    $cart_info[$id] = 1;
                    $added = true;
                }
            }
        }
        
        if (!$added)
        {
            $cart_info = array();
            $cart_info[$id] = 1;
            $added = true;
        }

        if ($added)
        {
            $cart_info = serialize($cart_info);
            \Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart', 'value' => $cart_info]));
        }
        $this->redirect(\Yii::$app->user->getReturnUrl());
    }
}
