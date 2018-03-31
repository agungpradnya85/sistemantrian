<?php
use yii\helpers\Html;
?>
<div style="text-align: center">  
<?=Html::img(Yii::getAlias('@web/img/sakbtransparant.png'), ['width'=> '525']); ?>
    <br>
<?=Html::a('Masuk',['service'],['class'=>'btn btn-lg btn-primary']); ?> </div>
<?php
$bgUrl = Yii::getAlias('@web/img/frontbadung.jpeg');
$css=<<<CSS
   body {
   background-color: #82a43a);
   background-repeat:no-repeat;
   background-size:contain;
   background-position:center;
}
CSS;
$this->registerCss($css);

?>
