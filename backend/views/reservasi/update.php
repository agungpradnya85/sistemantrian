<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\KlinikMap */

$this->title = 'Update Klinik Map: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Klinik Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="klinik-map-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
