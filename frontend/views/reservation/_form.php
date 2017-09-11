<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Citizen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citizen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'identity_number')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'birth_date')->textInput() ?>

    

    <?= $form->field($model, 'Address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
