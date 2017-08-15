<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\KlinikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kliniks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="klinik-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Klinik', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kode_klinik',
            'nama_klinik',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
