<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\KlinikMap */

$this->title = 'Create Klinik Map';
$this->params['breadcrumbs'][] = ['label' => 'Klinik Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="klinik-map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
