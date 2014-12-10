<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CategoryModel;
use app\models\CharacteristicModel;
use app\models\CharacteristicValueModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ProductModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-model-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'isAvailable')->textInput() ?>

    <?= $form->field($model, 'photo')->fileInput(['accept'=>"image/gif, image/jpeg, image/png"]) ?>

    <!-- <?= $form->field($model, 'rating')->textInput(['maxlength' => 1]) ?> -->

    <!-- <?= $form->field($model, 'amountRated')->textInput() ?> -->

    <?= $form->field($model, 'idCategory')->dropDownList(ArrayHelper::map(CategoryModel::find()->all(), 'id', 'name'),['readonly' => isset($model['idCategory'])]) ?>

    <?php
        if (isset($model['idCategory']) && isset($model['id']))
        {
            if (isset($model->idCategory))
            {
                $characteristics = CharacteristicModel::find()->where(['idCategory'=>$model['idCategory']])->all();
                $category = CategoryModel::find()->where(['id'=>$model['idCategory']])->one();
                while ($category['parentId']!=null)
                {   
                    $temp = CharacteristicModel::find()->where(['idCategory'=>$category['parentId']])->all();
                    foreach($temp as $temp_char)
                        $characteristics[] = $temp_char;
                    $category = CategoryModel::find()->where(['id'=>$category['parentId']])->one();
                }
            }
            $counter = 0;
            foreach($characteristics as $characteristic)
            {
                $char_model = CharacteristicValueModel::find()->where(['idProduct'=>$model['id'],'idCharacteristic'=>$characteristic->id])->one();
                if ($char_model == null)
                {
                    $char_model = new CharacteristicValueModel;
                    $char_model->idProduct = $model['id'];
                    $char_model->idCharacteristic = $characteristic->id;
                }
                echo Html::activeHiddenInput($char_model,"[$counter]idProduct");
                echo Html::activeHiddenInput($char_model,"[$counter]idCharacteristic");
                echo $form->field($char_model,"[$counter]value",['labelOptions' => ['label' => $characteristic->name.' ('.$characteristic->value.')']])->textInput();
                $counter++;
            }
        }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
