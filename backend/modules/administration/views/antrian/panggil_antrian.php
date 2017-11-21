<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Halaman Kelola Antrian '.$klinik -> nama_klinik;
?>
<h1><?= Html::encode($this->title); ?></h1>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <table class="table">
            <tr>
                <th>Nama</th>
                <th>No Antrian</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Batalkan Reservasi</th>
                <th>
            </tr>
            <?php foreach($model as $result) :?>          
            <tr>
                <td>
                 <?= $result['nama']; ?>
                </td>
                <td>
                <?= $result['no_antrian']; ?>
                </td>
                <td>
                <?php if($result['status'] == 1): ?>
                    Aktif
                    <?php elseif($result['status'] == 2): ?>
                    Terdaftar
                    <?php else : ?>
                    Dibatalkan
                <?php endif ?>
                    
                </td>
                <td>
                 <?=$result['tanggal']; ?>
                </td>            
               
                <td>
                <?php if($result['status'] != 1 ):?>
                    Batal
                    <?php else :?>
                    <?= Html::a('Batal', ['update-antrian', 'id' => $result['id'], 'status' => '0','id_klinik' => $result['id_klinik']]); ?>                    
                    <?php endif; ?>
                </td>
            </tr>
            <?php    endforeach; ?>
            
        </table>
        <tr>
               <a href="javascript:history.go(-1)">Kembali</a>
        </tr>
</div>
</div>