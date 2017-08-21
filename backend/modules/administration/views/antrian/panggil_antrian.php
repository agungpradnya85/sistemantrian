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
                <th>No Antrian</th>
                <th>Panggil Pasien</th>
                <th>Daftarkan Pasien</th>
                <th>Batalkan Reservasi</th>
                <th>
            </tr>
            <?php foreach($model as $result) :?>
            <tr>
                <td>
                <?= $result['no_antrian']; ?>
                </td>
                <td>
                <?= Html::button('Panggil') ?>
                </td>
                <td>
                    <!--<button class="btn">Panggil</button>
                    <button class="btn">Set</button>-->
                    <?php if($result['status'] != 1) :?>
                    Daftar                  
                    <?php else : ?>
                    <?= Html::a('Daftar', ['update-antrian', 'id' => $result['id'], 'status' => '2', 'id_klinik' => $result['id_klinik']]); ?>
                    <?php endif; ?>
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