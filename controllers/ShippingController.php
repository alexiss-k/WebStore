<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class ShippingController extends Controller
{

    public function actionEmsShipping()
    {
        //Count EMS shipping
        sleep(2);
        echo 150.34;
    }

    public function actionDhlShipping()
    {
        //Count DHL shipping
        echo 111250.12;
    }

    public function actionFedexShipping()
    {
        //Count FedEx shipping
        echo 312.56;
    }

    public function actionUkrainepostShipping()
    {
        //Count Ukraine Post shipping
        echo 20.14;
    }

    public function actionNovaPostaShipping()
    {
        //Count Nova Posta shipping
        echo 35.46;
    }
}