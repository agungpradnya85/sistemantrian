<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CitizenSearch */
/* @var $form yii\widgets\ActiveForm */


$init_link = [
    'citizens' => $citizens,
    'faskes_id' => $faskes_id,
    'type' => $type,
    //'kecamatan_id' => $kecamatan_id,
    'klinik_id' => $klinik_id
];
if(null != Yii::$app->request->get('kecamatan_id')) {
      $init_link  = array_merge ($init_link, ['kecamatan_id' => Yii::$app->request->get('kecamatan_id') ]);
}

?>

<div class="citizen-search">

    <?php   echo Html::beginForm(array_merge(['search-data'], $init_link), 'get', ['id' => 'registerForm']); ?>

    <?php if ( Yii::$app -> request -> get('citizens') == 'nonbadung'): ?>
    <h3><?= Html::a('Pendaftaran', array_merge(['create'], $init_link)); ?> </h3>
    <?php endif ?>
    
    
    <div><h3>Pencarian data berdasar NIK:</h3></div>
    <?= Html::textInput('nik', null, ['id' => 'nik']); ?>
    
    <?php // $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'propinsi') ?>

    <?php // echo $form->field($model, 'kabupaten') ?>

    <?php // echo $form->field($model, 'kecamatan') ?>

    <?php // echo $form->field($model, 'alamat') ?>
    
    <div class="form-group">
        <br>
        <?= Html::submitButton('Cari Data', ['class' => 'btn btn-primary', 'id' => 'submit']) ?>
        
    </div>

    <?php echo Html::endForm(); ?>

</div>

<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Kesalahan</h4>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>

<?php
$js=<<<JS
    
    jQuery('#submit').on('click', function(e) {
        e.preventDefault();
        var nik = jQuery('#nik').val();
        var form = $('#registerForm');
        //console.log(form.serialize(), form.prop('action'));
        if(nik.length === 0) {
            showAlert('NIK harap diisi');
        }
        else {
            window.location.href = form.prop('action') + '?' + form.serialize();
            return true;
        }
    });

    function showAlert(message) {
        jQuery('#myModal .modal-body').html(message);
        jQuery('#myModal').modal('show');
    }
        
    $('#myModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-body').empty();
    })
JS;
$this->registerJs($js);

$css =<<<CSS

CSS;
$this->registerCss($css);
?>