<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Pilih Kecamatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php foreach ($model as $kecamatan): ?>

<div class="col-md-4">
    <h3><?= Html::a($kecamatan->nama, ['health-service', 'kecamatan_id' => $kecamatan->id, 'type' => $type]); ?></h3>
    <p><?= Html::a(Html::img(Yii::getAlias('@web/img/bed-hospital.png'),['width' => '150', 'height' => '150']), ['health-service', 'kecamatan_id' => $kecamatan->id, 'type' => $type]); ?></p>
</div>

<?php endforeach; ?>


</div>