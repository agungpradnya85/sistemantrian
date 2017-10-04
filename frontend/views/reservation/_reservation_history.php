<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$formatter = Yii::$app->formatter;
?>
<?php
if($result !== null) :?>
<table class="table table-striped table-bordered">
<thead>
    <tr>
    <th>Waktu Layanan</th>
    <th>NIK</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
<?php foreach($result as $daftar_antrian) :?>
    <tr>
    <td><?= $formatter->asDate($daftar_antrian['time_exam_start'],'php:d/m/Y H:i');?> - <?= $formatter->asDate($daftar_antrian['time_exam_end'],'php:d/m/Y H:i');?></td>
    <td><?= $daftar_antrian['nik'];?></td>
    <td><?= $daftar_antrian['nama'];?></td>
    <td><?= $daftar_antrian['alamat'];?></td>
    <td><?= Html::a('batal', [
            'reservation/cancel-reservation',
            'id' => $daftar_antrian['id'],
            'identity' => $daftar_antrian['nik']
        ]);?></td>
    </tr>
<?php endforeach;?>
</tbody>
</table>
<?php endif; ?>