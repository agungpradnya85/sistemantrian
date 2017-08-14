<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
?>
<?= Html::beginForm(); ?>
<div class="form-group">
    <label>Klinik</label><?= Html::dropDownList('klinik', null, ['1' => 'Poliklinik Umum']); ?>
</div>
<div class="form-group">
    <input type="submit" value="Next">
</div>
<?= Html::endForm(); ?>