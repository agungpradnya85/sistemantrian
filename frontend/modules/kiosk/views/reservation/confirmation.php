<?php

use yii\helpers\Html;
?>
<h1>Konfirmasi Antrean</h1>
<?= Html::beginForm(['reservation/confirmation',], 'post', ['enctype' => 'multipart/form-data', 'id' => 'add-reservation', 'class' => 'form-horizontal']);?>
<div class="form-group">
    <label for="idenity" class="control-label col-sm-2 col-xs-6">Nomor Referensi</label>
    <div class="col-sm-4 col-xs-6">
    <?= Html::textInput('refnumber', null, ['id' => 'write']); ?>
    </div>
</div>
<?= $this->render('keyboard'); ?>

<?php
    
    echo Html::submitButton('Submit', ['id' => 'save-reservation', 'class' => 'btn btn-primary']);
    echo Html::endForm();
    ?>