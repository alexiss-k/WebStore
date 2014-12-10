<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CharacteristicModel;
use app\models\ProductModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicValueModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristic-value-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idProduct')->dropDownList(ArrayHelper::map(ProductModel::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'idCharacteristic')->dropDownList(ArrayHelper::map(CharacteristicModel::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
