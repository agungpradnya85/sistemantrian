<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Citizen */

$this->title = $model->nik;
$this->params['breadcrumbs'][] = ['label' => 'Citizens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citizen-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->nik], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->nik], [
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
            'nik',
            'tipe',
            'tanggal_lahir',
            'kelurahan',
            'nama',
            'propinsi',
            'kabupaten',
            'kecamatan',
            'alamat',
        ],
    ]) ?>

</div>
