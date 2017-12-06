<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<h1>Sistem Antrian Online</h1>
<div class="site-index">

    
    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <br>
                <h2>Rumah Sakit</h2>
                <p><?= Html::a(Html::img(Yii::getAlias('@web/img/hospital-red.jpg'), ['width' => '180' , 'height' => '180']), ['region/health-service', 'type' => 'rumahsakit']);?></p>              
            </div>
            <div class="col-lg-6">
                <br>
                <h2>Puskesmas</h2>
                <p>
                    <?= Html::a(Html::img(Yii::getAlias('@web/img/puskesmas.png'), ['width' => '180', 'height' => '180']), ['region/index', 'type' => 'puskesmas']); ?></p>               
            </div>
           
        </div>

    </div>
</div>
