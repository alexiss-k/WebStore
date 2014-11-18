<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CategoryModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?php
    $categories = ArrayHelper::map(CategoryModel::find()->all(), 'id', 'name');
    $categories[] = '';
    asort($categories);
    ?>

    <?= $form->field($model, 'parentId')->dropDownList($categories) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
