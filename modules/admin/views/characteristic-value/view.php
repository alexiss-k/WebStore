<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicValueModel */

$this->title = $model->idProduct;
$this->params['breadcrumbs'][] = ['label' => 'Characteristic Value Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-value-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idProduct' => $model->idProduct, 'idCharacteristic' => $model->idCharacteristic], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idProduct' => $model->idProduct, 'idCharacteristic' => $model->idCharacteristic], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idProduct',
            'idCharacteristic',
            'value',
        ],
    ]) ?>

</div>
