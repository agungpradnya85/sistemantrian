<?php

namespace frontend\controllers;

use Yii;
use common\models\Citizen;
use common\models\CitizenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservationController implements the CRUD actions for Citizen model.
 */
class ReservationController extends Controller
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
    public function actionIndex($faskes_id , $type, $citizens, $kecamatan_id)
    {
        $searchModel = new CitizenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'citizens' => $citizens,
            'faskes_id' => $faskes_id,
            'type' => $type,
            'kecamatan_id' => $kecamatan_id
        ]);
    }

    /**
     * Displays a single Citizen model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Citizen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \common\models\NonCitizen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nik]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSearchData($citizens)
    {
        
        $search = Yii::$app -> request->post('CitizenSearch');
        $nik = $search['nik'];
        if($citizens === 'nonbadung') 
        {
                $model = NonCitizen::find()->where(['identity_number' => $nik])
                -> one();
        }else {
                 $model = Citizen::find()->where(['nik' => $nik])
                ->one();
        }
        
        return $this->render('search_data', [
                'model' => $model,
        ]);    
    }
    
    public function actionAdd()
    {
        if(Yii::$app->request->post()) {
            $id_klinik = Yii::$app->request->post('klinik');
            $tanggal_layanan = Yii::$app->request->post('tanggal_layanan');
            $id_user = Yii::$app->request->post('nik');
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
    // Ini Id yang menunjukkan id klinik map di database
    public function actionShow($id)
    {
        $queryCount = "SELECT * FROM `klinik_map` WHERE id=:id";
        $model = Yii::$app->db->createCommand($queryCount, [
                        ':id' => $id
                    ])->queryOne();
        return $this->render('show_antrian', ['model' => $model]);
    }
    
    public function actionCancelReservation($id)
    {
        //if(Yii::$app->request->post()) {
            

            //$id_user = Yii::$app->user -> identity->id;
            //$id_klinik = Yii::$app->request->post('id_klinik');
            //$id = Yii::$app->request->post('id');
            $query = "UPDATE klinik_map SET [[status]] =:status WHERE id=:id";
            Yii::$app->db->createCommand($query, [
                    ':status' => 0,
                    //':id_user' => $id_user,
                    //':id_klinik' => $id_klinik,
                    ':id' => $id,
                ])
		->execute();
            return $this -> redirect(['/site/index']);
        //}
    }
}
