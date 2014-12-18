<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ProductModel;
use app\models\ShippingModel;

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
                    'delete' => ['post'],
                    'set-info' => ['post'],
                ],
            ],
        ];
    }

    public function actionView()
    {
        $cart_info = \Yii::$app->request->cookies->getValue('cart');
        $cart_info = unserialize($cart_info);
        if (is_array($cart_info)) {
            $products = ProductModel::getProducts(array_keys($cart_info));//find()->where(['id'=>array_keys($cart_info)])->all();
            $shippings = ShippingModel::getShippings();//find()->all();
            return $this->render('view',['cart'=>$cart_info,'products'=>$products,'shippings'=>$shippings]);
        }
        else 
            return $this->render('empty');
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
        return $this->redirect(\Yii::$app->user->getReturnUrl());
    }

    public function actionSetInfo()
    {
        $cart_info = \Yii::$app->request->cookies->getValue('cart');
        $cart_info = unserialize($cart_info);
        $cart_info = \Yii::$app->request->post('Cart');
        \Yii::$app->getSession()->setFlash('shipping_method', \Yii::$app->request->post('shipping'));
        //echo \Yii::$app->request->post('shipping');
        \Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart', 'value' => serialize($cart_info)]));
        return $this->redirect('refresh-cart');
    }

    public function actionRefreshCart()
    {
        $cart_info = \Yii::$app->request->cookies->getValue('cart');
        if ($cart_info !== null) {
            $cart_info = unserialize($cart_info);
            if (is_array($cart_info)) {
                foreach ($cart_info as $product_id => $quantity)
                {
                    if ($quantity == 0)
                        unset($cart_info[$product_id]);
                }
                if (count($cart_info)>0)
                    \Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart', 'value' => serialize($cart_info)]));
                else
                    \Yii::$app->response->cookies->add(new \yii\web\Cookie(['name' => 'cart', 'value' => serialize('')]));
            }
        }
        return $this->redirect('view');
    }
}
