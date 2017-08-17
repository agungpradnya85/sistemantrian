<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Daftar Antrian';

?>
<h1><?= Html::encode($this->title); ?></h1>

<div class="row" style="font-size: 50px">
    <table><tr><th>Nama Poli</th><th>Antrian Terakhir</th><th>Antrian Yang Terlayani</th></tr>
    <?php    foreach ($model as $result) :?>
        <tr>
            <td><?= Html::a($result['nama_klinik'], ['panggil-antrian', 'id' => $result['id']]); ?></td>
            <td><?= $result['latest_queue']; ?></td>
            <td><?= $result['current_queue']; ?></td>
        </tr>
    <?php    endforeach; ?>
    </table>
</div>
