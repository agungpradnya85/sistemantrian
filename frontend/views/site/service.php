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
                <p><?= Html::a(Html::img(Yii::getAlias('@web/img/rumahsakitbiru.png'), ['width' => '170']), ['region/health-service', 'type' => 'rumahsakit']);?></p>              
            </div>
            <div class="col-lg-6">
                <br>
                <h2>Puskesmas</h2>
                <p>
                    <?= Html::a(Html::img(Yii::getAlias('@web/img/puskesmashijau.png'), ['width' => '170']), ['region/index', 'type' => 'puskesmas']); ?></p>               
            </div>
           
        </div>

    </div>
</div>
    <!-- Start: Preloader section
    ========================== -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End: Preloader section
    ========================== -->
<?php
$js =<<<JS
JS;
$this->registerJsFile(Yii::getAlias('@web/script/preloader.js'), [ 'depends' => [ \yii\web\JqueryAsset::className() ] ]);
$this->registerCssFile(Yii::getAlias('@web/cas/preloader.css'));
?>