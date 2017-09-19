<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
?>
<h1>Selamat Datang <?= $model['nama'] ;?></h1>
<br><b> NIK : <?= $model['nik'] ;?> 
<br>
<br> Pilih Tanggal Pelayanan : 

<?php
echo Html::beginForm(['reservation/add',], 'post', ['enctype' => 'multipart/form-data']);
    echo DatePicker::widget([
        'name' => 'tanggal_layanan',
        'type' => DatePicker::TYPE_INPUT,
        //'value' => '23-Feb-1982',
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    echo '<input type="hidden" name="nik" value="'.$model['nik'].'">';
    echo '<input type="hidden" name="klinik" value="'.$klinik_id.'">';
    echo ' <br>';
    echo Html::submitButton('Ambil Nomor Antrean');
    echo Html::endForm();
    ?>
