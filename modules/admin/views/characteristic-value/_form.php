<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicValueModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristic-value-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idProduct')->textInput() ?>

    <?= $form->field($model, 'idCharacteristic')->textInput() ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
