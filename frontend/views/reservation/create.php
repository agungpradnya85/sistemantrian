<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Citizen */

$this->title = 'Pendaftaran Pasien Non Badung';
$this->params['breadcrumbs'][] = ['label' => 'Penduduk Non Badung', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Penduduk Non Badung', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citizen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
