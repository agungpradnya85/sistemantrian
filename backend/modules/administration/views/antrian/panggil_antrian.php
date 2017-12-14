<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Halaman Kelola Antrian '.$klinik -> nama_klinik;
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <table class="table">
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>No Antrian</th>
                <th>Status</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Batalkan Reservasi</th>
                <th>
            </tr>
            <?php foreach($model as $result) :?> 
            <tr>
                <td>
                 <?= $result['nama']; ?>
                </td>
                <td>
                 <?= $result['id_pasien']; ?>
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
                 <?=$result['time_exam_start']; ?>
                </td>
                 <td>
                 <?=$result['time_exam_end']; ?>
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
   
</div>
         <tr>
               <a href="javascript:history.go(-1)">Kembali</a>
        </tr>
</div>