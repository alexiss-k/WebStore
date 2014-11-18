<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PaymentModel;
use app\models\ShippingModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\OrderModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUser')->textInput() ?>

    <?= $form->field($model, 'totalPrice')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'idPayment')->dropDownList(ArrayHelper::map(PaymentModel::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'idShipping')->dropDownList(ArrayHelper::map(ShippingModel::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'paymentStatus')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
