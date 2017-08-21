<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Halaman Kelola Poli';

?>
<h1><?= Html::encode($this->title); ?></h1>

<div class="row" style="font-size: 20px">
    <table class='table'><tr><th>Nama Poli</th><th>No Antrian Terakhir</th><th>No Antrian Yang Terdaftar Terakhir</th></tr>
    <?php    foreach ($model as $result) :?>
        <tr>
            <td><?= Html::a($result['nama_klinik'], ['panggil-antrian', 'id' => $result['id']]); ?></td>
            <td><?= $result['latest_queue']; ?></td>
            <td><?= $result['current_queue']; ?></td>
        </tr>
    <?php    endforeach; ?>
    </table>
</div>
<tr>
        <a href="javascript:history.go(-1)">Kembali</a>
</tr>
