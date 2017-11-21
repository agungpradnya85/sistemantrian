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
                <h2>Rumah Sakit</h2>
                <p><?= Html::a(Html::img('http://www.datatempat.com/wp-content/uploads/2017/02/RSUD-Kab.-Badung-Mangusada.jpg', ['width' => '300' , 'height' => '220']), ['region/health-service', 'type' => 'rumahsakit']);?></p>              
            </div>
            <div class="col-lg-6">
                <h2>Puskesmas</h2>
                <p>
                    <?= Html::a(Html::img('https://www.dikes.badungkab.go.id/assets/album/Puskesmas-Kuta-Utara_777923.jpg', ['width' => '300', 'height' => '220']), ['region/index', 'type' => 'puskesmas']); ?></p>               
            </div>
           
        </div>

    </div>
</div>
