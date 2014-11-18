<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\ProductModel;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\CommentModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUser')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'idProduct')->dropDownList(ArrayHelper::map(ProductModel::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => 600]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

	<?= $form->field($model,'date')->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => '2014-01-01']])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
