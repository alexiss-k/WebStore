<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PriceHistoryModel */

$this->title = 'Update Price History Model: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Price History Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="price-history-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
