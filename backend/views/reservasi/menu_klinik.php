<?php


use yii\bootstrap\BootstrapPluginAsset;
use yii\web\JqueryAsset;
use yii\helpers\Html;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Halaman Reservasi Antrian'
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= Html::beginForm(); ?>
<div class="form-group">
    <label>Nama Klinik</label><br><?= Html::dropDownList('klinik', null, [],[ 'id' => 'select-klinik', 'style' => 'width:100%']); ?>
</div>
<div class="form-group">
    <label>Antrian Terakhir : </label><span id="latest_queue"></span>
</div>
<div class="form-group">
    <label>Antrian Yang Terdaftar Terakhir : </label><span id="current_queue"></span>
</div>
<div class="form-group">
    <input type="submit" value="Ambil No Antrian">
</div>
<?= Html::endForm(); ?>

<?php
$search_klinik_url = Url::to(['/klinik/search-klinik']);
$queue_url = Url::to(['/antrian/show-antrian']);

$js =<<<JS
jQuery("#select-klinik").select2({
    placeholder : "-",
    allowClear : true,
    ajax: {
        url: "{$search_klinik_url}",
        crossDomain: true,
        dataType: 'jsonp',
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.results,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    //minimumInputLength: 1,
    templateResult: function(result) { 
        return "<div style=\"padding:2px 0\";><div>"+result.text+"</div></div>";
    },
    templateSelection: function (result) {
        return result.text;
    },
});
        
$('#select-klinik').on("select2:close", function(e) { 
    $.ajax({
        url: "{$queue_url}",
        data : {id : $(this).val()},
        dataType: 'json',
        delay: 250,
        success: function(data) {
            jQuery("#current_queue").text(data.current_queue);
            jQuery("#latest_queue").text(data.latest_queue);
        }
    });
});
JS;

$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
    ['depends' => [JqueryAsset::className()]]
);

$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css', [
    'depends' => [BootstrapPluginAsset::className()]
]);
$this->registerJs($js);
?>