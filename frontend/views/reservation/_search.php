<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CitizenSearch */
/* @var $form yii\widgets\ActiveForm */


$init_link = [
    'citizens' => $citizens,
    'faskes_id' => $faskes_id,
    'type' => $type,
    //'kecamatan_id' => $kecamatan_id,
    'klinik_id' => $klinik_id
];
if(null != Yii::$app->request->get('kecamatan_id')) {
      $init_link  = array_merge ($init_link, ['kecamatan_id' => Yii::$app->request->get('kecamatan_id') ]);
}

?>

<div class="citizen-search">

    <?php   echo Html::beginForm(array_merge(['search-data'], $init_link),'get'); ?>

    <?php if ( Yii::$app -> request -> get('citizens') == 'nonbadung'): ?>
    <h3><?= Html::a('Pendaftaran', array_merge(['create'], $init_link)); ?> </h3>
    <?php endif ?>
    
    
    <div><h3>Pencarian data berdasar NIK:</h3></div>
    <?= Html::textInput('nik', null); ?>
    
    <?php // $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'propinsi') ?>

    <?php // echo $form->field($model, 'kabupaten') ?>

    <?php // echo $form->field($model, 'kecamatan') ?>

    <?php // echo $form->field($model, 'alamat') ?>
    
    <div class="form-group">
        <br>
        <?= Html::submitButton('Cari Data', ['class' => 'btn btn-primary']) ?>
        
    </div>

    <?php echo Html::endForm(); ?>

</div>
