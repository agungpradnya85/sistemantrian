<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CitizenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citizens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citizen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel, 'citizens' => $citizens, 'faskes_id' => $faskes_id, 'type' => $type, 'kecamatan_id' => $kecamatan_id]); ?>

   
</div>
