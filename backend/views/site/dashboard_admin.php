<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Dashboard Administrator';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <H3>
                    <?= Html::a('Kelola Poli', ['/administration/antrian/index']); ?>
                </H3>
            </div>
        </div>
    </div>
</div>
