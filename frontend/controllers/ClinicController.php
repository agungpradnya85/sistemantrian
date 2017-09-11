<?php

namespace frontend\controllers;

use Yii;
use common\models\Citizen;
use common\models\CitizenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        return $this->render('index', ['model' => $model ,'faskes_id' => $faskes_id, 'citizens' => $citizens, 'type' => $type ]);
    }
    /*public function actionIndex()
    {
        $searchModel = new CitizenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Citizen model.
     * @param string $id
     * @return mixed
     */
  
}
