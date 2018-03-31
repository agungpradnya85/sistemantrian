<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">    
    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h3>Penduduk Badung</h3>

                <p><?= Html::a(Html::img(Yii::getAlias('@web/img/pendudukbadung.png'), ['width' => '170']), (null !== Yii::$app->request->get('kecamatan_id')) ? ['clinic/index', 'faskes_id' => $faskes_id, 'type' => $type, 'citizens' => 'badung', 'kecamatan_id' => Yii::$app->request->get('kecamatan_id')] : ['clinic/index', 'faskes_id' => $faskes_id, 'citizens' => 'badung', 'type' => $type]);?></p>

               
            </div>
            <div class="col-lg-6">
                <h3>Penduduk Non Badung</h3>
                <p>
                    <?= Html::a(Html::img(Yii::getAlias('@web/img/penduduknonbadung.png'), ['width' => '170']), (null !== Yii::$app->request->get('kecamatan_id')) ? ['clinic/index', 'faskes_id' => $faskes_id, 'type' => $type, 'citizens' => 'nonbadung', 'kecamatan_id' => Yii::$app->request->get('kecamatan_id')] : ['clinic/index', 'faskes_id' => $faskes_id, 'citizens' => 'nonbadung','type' => $type]); ?></p>            
            </div>
           
            <div class="col-lg-6">
                <p>
                    <?= Html::a(Html::img(Yii::getAlias('@web/img/konfirm.png'), ['width' => '200']), ['reservation/confirmation', 'type' => 'puskesmas']); ?></p>            
            </div>
        </div>

    </div>
</div>


