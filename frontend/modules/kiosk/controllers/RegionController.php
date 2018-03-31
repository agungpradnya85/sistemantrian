<?php
namespace frontend\modules\kiosk\controllers;

use Yii;
use yii\web\Controller;
use common\models\Kecamatan;
use common\models\Faskes;

/**
 * Site controller
 */
class RegionController extends Controller
{
    public function actionIndex($type)
    {
        $model = Kecamatan::find()->all();
        return $this->render("@frontend/views/region/index", ['model' => $model, 'type' => $type]);
    }
    
    public function actionHealthService($type)
    {
        $condition = ($type === 'puskesmas') ? [
            'tipe' => $type,
            'kecamatan' => Yii::$app->request->get('kecamatan_id'),
        ] : [
            'tipe' => $type,
        ];
        $model = Faskes::find()->where($condition)->all();
        return $this->render("@frontend/views/region/health_service", ['model' => $model, 'type' => $type]);
    }
}
