<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Halaman Informasi Booking Antrian'
?>
<h1><?= Html::encode($this->title) ?></h1><br>
<div style="text-align: center; font-weight: bold; font-size: 40px;">
    <div>No Antrian</div>
    <div><?= $model['no_antrian']; ?></div>
    <div>Perkiraan Waktu Pemeriksaan</div>
    <div><?= $model['time_exam']; ?></div>
    <div><?=        yii\helpers\Html::a('Batal',['reservation/cancel-reservation','id' => Yii::$app -> request -> get('id')]);?></div>
</div>
 