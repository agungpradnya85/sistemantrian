<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <?php
    $init_link = ['reservation/index', 'faskes_id' => $faskes_id, 'type' => $type,  'citizens' => $citizens, ];
    if(null != Yii::$app->request->get('kecamatan_id')) {
          $init_link  = array_merge ($init_link, ['kecamatan_id' => Yii::$app->request->get('kecamatan_id') ]);
    }
    ?>
<?php foreach ($model as $poli): ?>


<div class="col-md-4">
    <h3>Nama Poli : <?= Html::a($poli->nama_klinik, array_merge($init_link, ['klinik_id' => $poli->id])); ?></h3>
    <h3>Jumlah Poli : <?= $poli->jumlah_poli; ?></h3>
    <br>
    <p><?= Html::a(Html::img(Yii::getAlias('@web/img/iconpoli.png'),['width' => '170', 'height' => '170']), array_merge($init_link, ['klinik_id' => $poli->id])); ?></p>
</div>

<?php endforeach; ?>


</div>

