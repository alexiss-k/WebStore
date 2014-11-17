<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CharacteristicValueModel */

$this->title = 'Create Characteristic Value Model';
$this->params['breadcrumbs'][] = ['label' => 'Characteristic Value Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-value-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
