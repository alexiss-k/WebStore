<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicModel */

$this->title = 'Create Characteristic Model';
$this->params['breadcrumbs'][] = ['label' => 'Characteristic Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
