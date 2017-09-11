<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CitizenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citizen-search">

    <?php $form = ActiveForm::begin([
        'action' => ['search-data', 'citizens' => $citizens],
        'method' => 'post',
    ]); ?>

    <?php if ( Yii::$app -> request -> get('citizens') == 'nonbadung'): ?>
    <?= Html::a('Registrasi', ['create', 'faskes_id' => $faskes_id, 'type' => $type, 'kecamatan_id' => $kecamatan_id ]) ?>
    <?php endif ?>
    

    <?= $form->field($model, 'nik') ?>

    <?= $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'propinsi') ?>

    <?php // echo $form->field($model, 'kabupaten') ?>

    <?php // echo $form->field($model, 'kecamatan') ?>

    <?php // echo $form->field($model, 'alamat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
