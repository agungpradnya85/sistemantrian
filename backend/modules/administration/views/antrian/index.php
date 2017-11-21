<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'Halaman Kelola Poli';
$width_pos = 0;
$selectedDateUrl = Url::to(['index']);
?>
<h1><?= Html::encode($this->title); ?></h1>
<h3>Pilih Tanggal :</h3>

<div id="date-selector">
    <?= DatePicker::widget([
            'name' => 'tanggal_layanan',
            'id' => 'tanggal_layanan',
            'type' => DatePicker::TYPE_INPUT,
            'value' => $selectedDate,
            'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
    ?>
    <br>  <?= Html::button('Tampilkan', ['id' => 'submit-date']);?>
     <div>
        <tr>
          <a href="javascript:history.go(-1)">Kembali</a>
       </tr>
    </div>
</div>
<br>
<div class="row">
    <div style="font-size: 1em; position: relative">
        
    <h3>Daftar Poli</h3>
    <?php foreach($model as $poli) :?>
    
    <!-- faskes -->
    
    <div style="position:absolute; left: <?= $width_pos; ?>px">
        <?= Html::a($poli[0]['nama_klinik'], ['antrian/panggil-antrian', 'id' => $poli[0]['id_klinik'], 'selected_date'=>$selectedDate]); ?>
        <table class="table table-bordered">
            <tr>
                <th>No. Antrian</th>
                <th>Status</th>
                <th>Panggil</th>
                <th>Daftar</th>
            </tr>
        <?php foreach ($poli as $detail) :?>
        
            <?php if(strlen($detail['no_antrian']) > 0 ): ?>

            <?php 
                $antrianTxt = (strtolower($detail['no_antrian']) == 'a2') ? 'A Dua' : $detail['no_antrian'];
                $textJs = "Nomor antrian {$antrianTxt}, {$detail['nama_klinik']}, harap datang ke meja operator!";
            ?>
            <tr>
                <td><?= $detail['no_antrian']; ?></td>
                <td><?= $detail['status_antrian']; ?></td>
                <td><button class="butt js--triggerAnimation btn btn-success btn-sm" onclick="responsiveVoice.speak('<?= $textJs; ?>', 'Indonesian Female', {rate: 0.7, volume : 1, pitch: 1});" type="button" value="Play"><span class="glyphicon glyphicon-bullhorn"></span></button></td>
                <td><?php if(Yii::$app->request->get('selected_date') === null) : ?>
                    <?= Html::a('Daftar', ['update-antrian', 'id' => $detail['id_klinik_map'], 'status' => 2, 'id_klinik' => $detail['id_klinik']]); ?>
                    <?php else : ?>
                    <?= Html::a('Daftar', ['update-antrian', 'selected_date' => $selectedDate, 'id' => $detail['id_klinik_map'], 'status' => 2, 'id_klinik' => $detail['id_klinik']]); ?>
                    <?php endif; ?></td>              
            </tr>
            <?php endif; ?>          
        <?php endforeach; ?>
            </table>
    </div>
    
    <?php $width_pos +=350; ?>
   
    <?php endforeach; ?>
       
    </div>  
   
</div>


<?php
$js=<<<JS
jQuery('#submit-date').on('click', function(e){
    window.location.href = "{$selectedDateUrl}?selected_date="+jQuery('#tanggal_layanan').val();
});
JS;
$this->registerJs($js);
?>


