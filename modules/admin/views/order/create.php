<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrderModel */

$this->title = 'Create Order Model';
$this->params['breadcrumbs'][] = ['label' => 'Order Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
