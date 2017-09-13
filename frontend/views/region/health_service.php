<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
<?php foreach ($model as $faskes): ?>

<div class="col-md-4">
    <h3><?= Html::a($faskes->nama, (null !== Yii::$app->request->get('kecamatan_id')) ? ['citizen/index', 'faskes_id' => $faskes->id, 'type' => $type, 'kecamatan_id' => Yii::$app->request->get('kecamatan_id')] : ['citizen/index', 'faskes_id' => $faskes->id, 'type' => $type]); ?></h2>
    <p><?= Html::img(Yii::getAlias('@web/img/logo_mangusada.png'),['width' => '150', 'height' => '150']); ?></p>
</div>
<?php endforeach; ?>


</div>
