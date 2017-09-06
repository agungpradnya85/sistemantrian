<?php

namespace backend\controllers;

use Yii;
use common\models\KlinikMap;
use common\models\KlinikMapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AppAccessRule;

/**
 * ReservasiController implements the CRUD actions for KlinikMap model.
 */
class ReservasiController extends Controller
{
    public $enableCsrfValidation = false;
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
            
            // acess control role
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AppAccessRule::className(),
                ],
                
                //'only' => ['index','create','update','view','poli','show','show-antrian'],
                'rules' => [
                    // allow authenticated users
                    
                    // only role member
                    [
                        'actions' => ['index','create','update','view','poli','show','cancel-reservation-member'],
                        'allow' => true,
                        'roles' => ['member'],
                    ],
                    
                    // only user member
                    /*[
                        'actions' => ['show'],
                        'allow' => true,
                        'roles' => ['member'],
                    ],*/
                    // everything else is denied
                ],
            ],

        ];
    }

    /**
     * Lists all KlinikMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KlinikMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KlinikMap model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new KlinikMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KlinikMap();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing KlinikMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing KlinikMap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the KlinikMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KlinikMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KlinikMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    // menampilkan informasi antrian di 
    public function actionPoli()
    {
         
        //return $this->render('index', ['model' => $model]);
        
        if(Yii::$app->request->post()) {
            $id_klinik = Yii::$app->request->post('klinik');
            $id_user = Yii::$app->user->identity->id;
            $data_klinik = \common\models\Klinik::findOne($id_klinik);
            $queryCount = "SELECT count(*) FROM `klinik_map` WHERE id_klinik=:id_klinik and tanggal=:date";
            $count = Yii::$app->db->createCommand($queryCount, [
                        ':id_klinik' => $id_klinik,
                        ':date' => date('Y-m-d')
                    ])
                    ->queryScalar();
            $next_queue = $count + 1;
            Yii::$app->db->createCommand()
                    ->insert('klinik_map', [
                        'id_klinik' => $id_klinik,
                        'tanggal' => date('Y-m-d'),
                        'no_antrian' => $data_klinik->kode_klinik.''.$next_queue,
                        'id_pasien' => $id_user,
                        'time_exam' => $this->showTimeExamination($next_queue),
                    ])->execute();
            $id = Yii::$app->db->getLastInsertID();
            return $this->redirect(['show', 'id' => $id]);
        }
        return $this->render('menu_klinik');
    }
    
    protected function showTimeExamination($antrian)
    {
        if($antrian >= 1 && $antrian <= 12)
        {
            $timeExamination = '08.00 - 10.00';
        }else if($antrian >= 13 && $antrian <= 24)
        {
            $timeExamination = '10.00 - 12.00';
        }else if($antrian >= 25 && $antrian <= 36)
        {
            $timeExamination = '12.00 - 14.00';
        }
        else if($antrian >= 37 && $antrian <= 48)
        {
            $timeExamination = '14.00 - 16.00';
        }
        else if($antrian >= 49 && $antrian <= 60)
        {
            $timeExamination = '16.00 - 18.00';
        }
        return $timeExamination;
    }

        public function actionShowAntrian()
    {
        if(Yii::$app->request->post()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //$id_klinik = Yii::$app->request->post('klinik');
            $id_user = Yii::$app->request->post('id_user');
            $id_klinik = Yii::$app->request->post('id_klinik');
            $data_klinik = \common\models\Klinik::findOne($id_klinik);
            $queryCount = "SELECT count(*) FROM `klinik_map` WHERE id_klinik=:id_klinik and tanggal=:date";
            $count = Yii::$app->db->createCommand($queryCount, [
                        ':id_klinik' => $id_klinik,
                        ':date' => date('Y-m-d')
                    ])
                    ->queryScalar();
            
            Yii::$app->db->createCommand()
                    ->insert('klinik_map', [
                        'id_klinik' => $id_klinik,
                        'tanggal' => date('Y-m-d'),
                        'no_antrian' => $data_klinik->kode_klinik.''.($count + 1),
                        'id_pasien' => $id_user,
                    ])->execute();
        //}
        return [
            'no_antrian' => $data_klinik->kode_klinik.''.($count + 1),
            'id_antrian' => Yii::$app->db->getLastInsertID(),
            'id_klinik' => $id_klinik,
            'id_user' => $id_user
        ];
    }
        //return $this->render('menu_klinik');
    }
    
    // membatalkan reservasi
    // android
    public function actionCancelReservation()
    {
        if(Yii::$app->request->post()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //$id_klinik = Yii::$app->request->post('klinik');
            $id_user = Yii::$app->request->post('id_user');
            $id_klinik = Yii::$app->request->post('id_klinik');
            $id = Yii::$app->request->post('id');
            $query = "UPDATE klinik_map SET [[status]] =:status WHERE id=:id AND id_pasien=:id_user AND id_klinik=:id_klinik";
            Yii::$app->db->createCommand($query, [
                    ':status' => 0,
                    ':id_user' => $id_user,
                    ':id_klinik' => $id_klinik,
                    ':id' => $id,
                ])
		->execute();
            return ['message' => 'success'];
        }
    }

    // Ini Id yang menunjukkan id klinik map di database
    public function actionShow($id)
    {
        $queryCount = "SELECT * FROM `klinik_map` WHERE id=:id";
        $model = Yii::$app->db->createCommand($queryCount, [
                        ':id' => $id
                    ])->queryOne();
        return $this->render('show_antrian', ['model' => $model]);
    }
    
    //$id adalah id klinik map
     public function actionCancelReservationMember($id)
    {
        //if(Yii::$app->request->post()) {
            

            $id_user = Yii::$app->user -> identity->id;
            //$id_klinik = Yii::$app->request->post('id_klinik');
            //$id = Yii::$app->request->post('id');
            $query = "UPDATE klinik_map SET [[status]] =:status WHERE id=:id AND id_pasien=:id_user";
            Yii::$app->db->createCommand($query, [
                    ':status' => 0,
                    ':id_user' => $id_user,
                    //':id_klinik' => $id_klinik,
                    ':id' => $id,
                ])
		->execute();
            return $this -> redirect(['/site/index']);
        //}
    }
}
