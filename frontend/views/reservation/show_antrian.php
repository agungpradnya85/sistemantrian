<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Halaman Informasi Booking Antrian';
$formatter = Yii::$app->formatter;
?>
<h1><?= Html::encode($this->title) ?></h1><br>
<div style="text-align: center; font-weight: bold; font-size: 40px;">
    <div>No Antrian</div>
    
    <div><?= $model['no_antrian']; ?></div>
    <br>
    <div>Perkiraan Waktu Pemeriksaan</div>
    <div><?= $formatter->asDate($model->time_exam_start, 'php:d M Y H:i'); ?> - <?= $formatter->asDate($model->time_exam_end, 'php:d M Y H:i'); ?></div> 
   <!-- <div><?= Html::a('Batal',['reservation/cancel-reservation','id' => Yii::$app -> request -> get('id')], ['class' => 'btn btn-primary btn-lg']);?></div> ->
</div>
 