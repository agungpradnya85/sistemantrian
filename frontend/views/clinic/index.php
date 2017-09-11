<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
<?php foreach ($model as $poli): ?>


<div class="col-md-4">
    <h2><?= Html::a($poli->nama_klinik, (null != Yii::$app->request->get('kecamatan_id')) ? ['reservation/index', 'faskes_id' => $faskes_id, 'type' => $type, 'citizens' => $citizens, 'kecamatan_id' => Yii::$app->request->get('kecamatan_id') ]
            : ['reservation/index', 'faskes_id' => $faskes_id, 'type' => $type,  'citizens' => $citizens, ] ); ?></h2>
     <h2><?= Html::a($poli->jumlah_poli, ['reservation/index', ]); ?></h2>
    <p><?= Html::img(Yii::getAlias('@web/img/hospital-clipart-hospital-png-830x747.png'),['width' => '150', 'height' => '150']); ?></p>
</div>

<?php endforeach; ?>


</div>

