<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="registration">

<h2>Registration</h2><br>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'phone')->textInput() ?>
        <?= $form->field($model, 'country')->textInput() ?>
        <?= $form->field($model, 'city')->textInput() ?>
        <?= $form->field($model, 'zipCode')->textInput() ?>
        <?= $form->field($model, 'address')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- registration -->
