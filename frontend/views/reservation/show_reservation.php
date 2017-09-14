<?php
use yii\helpers\Html;
?>

<div class="citizen-search">
    <h3>Cari Data Antrian</h3>
    <?= Html::beginForm(); ?>
    <?= Html::textInput("nik") ?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::endForm();?>
    
    
    <?php if($result !== null) :?>
    <table>
        <tr>
        <th>NIK</th>
        <th>Nama</th>
        <th>Aksi</th>
        </tr>
    
    <?php foreach($result as $daftar_antrian) :?>
        <tr>
        <td><?= $daftar_antrian['nik'];?></td>
        <td><?= $daftar_antrian['nama'];?></td>
        <td><?= Html::a('batal', ['reservation/cancel-reservation', 'id' => $daftar_antrian['id']]);?></td>
        </tr>
    
    <?php endforeach;?>
    </table>
    <?php endif; ?>

</div>