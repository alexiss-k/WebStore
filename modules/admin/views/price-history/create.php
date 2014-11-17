<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PriceHistoryModel */

$this->title = 'Create Price History Model';
$this->params['breadcrumbs'][] = ['label' => 'Price History Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-history-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
