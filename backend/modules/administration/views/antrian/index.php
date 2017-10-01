<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Halaman Kelola Poli';
$width_pos = 0;
?>
<h1><?= Html::encode($this->title); ?></h1>

<div class="row">
    <div style="font-size: 20px; position: relative">
    <?php foreach($model as $poli) :?>
    
    <!-- faskes -->
    
    <div style="position:absolute; left: <?= $width_pos; ?>px">

        <?= Html::a($poli[0]['nama_klinik'], ['antrian/panggil-antrian', 'id' => $poli[0]['id_klinik']]); ?>
        <table>
            <tr>
                <th>No. Antrian</th>
            </tr>
        <?php foreach ($poli as $detail) :?>
        
            <tr>
                <td><?= $detail['no_antrian']; ?></td>
            </tr>
        
            
        <?php endforeach; ?>
            </table>
    </div>
    <?php $width_pos +=300; ?>
    <?php endforeach; ?>
    </div>
</div>
