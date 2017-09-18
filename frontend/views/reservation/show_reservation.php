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
    
    <?php if($result !== null) :?>
    <table>
        <tr>
        <th>NIK</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Aksi</th>
        </tr>
    
    <?php foreach($result as $daftar_antrian) :?>
        <tr>
        <td><?= $daftar_antrian['nik'];?></td>
        <td><?= $daftar_antrian['nama'];?></td>
        <td><?= $daftar_antrian['alamat'];?></td>
        <td><?= Html::a('batal', ['reservation/cancel-reservation', 'id' => $daftar_antrian['id']]);?></td>
        </tr>
    
    <?php endforeach;?>
    </table>
    <?php endif; ?>

</div>