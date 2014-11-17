<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicValueModel */

$this->title = 'Update Characteristic Value Model: ' . ' ' . $model->idProduct;
$this->params['breadcrumbs'][] = ['label' => 'Characteristic Value Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idProduct, 'url' => ['view', 'idProduct' => $model->idProduct, 'idCharacteristic' => $model->idCharacteristic]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="characteristic-value-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
