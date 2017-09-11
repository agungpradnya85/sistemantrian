<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Citizen */

$this->title = 'Update Citizen: ' . $model->nik;
$this->params['breadcrumbs'][] = ['label' => 'Citizens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nik, 'url' => ['view', 'id' => $model->nik]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="citizen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
