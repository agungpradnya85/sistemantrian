<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
?>
<h1>Selamat Datang <?= $model['nama'] ;?></h1>
<br><b> NIK : <?= $model['nik'] ;?> 
<br>
<br> Pilih Tanggal Pelayanan : 

<?php
echo Html::beginForm(['reservation/add',], 'post', ['enctype' => 'multipart/form-data', 'id' => 'add-reservation']);
    echo DatePicker::widget([
        'name' => 'tanggal_layanan',
        'id' => 'tanggal_layanan',
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
    echo Html::submitButton('Ambil Nomor Antrean', ['id' => 'save-reservation']);
    echo Html::endForm();
    
    echo Html::a('Tampilkan Antrean Anda', ['reservation/show-reservation', 'type' => Yii::$app->request->get('type')], ['id' => 'show-history']);
    ?>
<div id="history-result"></div>
<?php
$js=<<<JS
    jQuery("#show-history").on("click", function(e) {
        
        e.preventDefault();
        jQuery.ajax({
            type : "POST",
            url : jQuery(this).attr("href"),
            dataType : "html",
            data : {"nik" : "{$model['nik']}", "tanggal_reservation" : jQuery("#tanggal_layanan").val()},
            beforeSend:function(){
                jQuery("#history-result").empty();
            },         
            success : function(data) {

                jQuery("#history-result").html(data);
            }
        });
        return false;

    });
    jQuery("#save-reservation").on("click", function(e) {
        e.preventDefault();
        jQuery.ajax({
            type : "POST",
            url : jQuery("#add-reservation").attr("action"),
            dataType : "json",
            data : jQuery("#add-reservation").serialize(),
           
            success : function(data) {
      
                if(data.error == true)
                {
                    alert(data.message);
                }
                else {
                    window.location.href = data.redirect;
                }
            }
        });
        return false;
    });
JS;
$this->registerJs($js);
?>