<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\KlinikMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="klinik-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_antrian')->textInput() ?>

    <?= $form->field($model, 'id_klinik')->textInput() ?>

    <?= $form->field($model, 'id_pasien')->textInput() ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
