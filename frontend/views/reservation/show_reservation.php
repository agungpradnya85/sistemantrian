<?php
use yii\helpers\Html;
?>

<div class="citizen-search">
    <h2>Cari Data Antrian</h2><br>
        <H3>Masukkan NIK:</H3>
    <?= Html::beginForm(); ?>
    <?= Html::textInput("nik") ?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm();?>
    
        <br>
    
    <?= $this->render('_reservation_history', ['result' => $result]); ?>

</div>