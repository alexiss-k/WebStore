<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CategoryModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristic-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idCategory')->dropDownList(ArrayHelper::map(CategoryModel::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
