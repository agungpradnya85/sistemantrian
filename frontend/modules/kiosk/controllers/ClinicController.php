<?php

namespace frontend\modules\kiosk\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * CitizenController implements the CRUD actions for Citizen model.
 */
class ClinicController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Citizen models.
     * @return mixed
     */
     public function actionIndex($faskes_id, $citizens, $type)
    {
        $model = \common\models\Klinik::find()->where(['id_faskes'=> $faskes_id])->all();
        return $this->render('@frontend/views/clinic/index', ['model' => $model ,'faskes_id' => $faskes_id, 'citizens' => $citizens, 'type' => $type ]);
    }
  
}
