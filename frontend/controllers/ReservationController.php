<?php

namespace frontend\controllers;

use Yii;
use common\models\Citizen;
use common\models\NonCitizen;
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
    public function actionIndex($faskes_id , $type, $citizens, $klinik_id)
    {
        $searchModel = new CitizenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'citizens' => $citizens,
            'faskes_id' => $faskes_id,
            'type' => $type,
            'klinik_id' => $klinik_id,
           // 'kecamatan_id' => $kecamatan_id
        ]);
    }

    /**
     * Displays a single Citizen model.
     * @param string $id
     * @return mixed
     */
   /** public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new Citizen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   // ?citizens=nonbadung&faskes_id=1&type=puskesmas&kecamatan_id=4&klinik_id=1
    public function actionCreate($citizens, $faskes_id, $type, $klinik_id)
    {
        $model = new \common\models\NonCitizen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['reservation/search-data', 
                'nik' => $model->identity_number,
                'citizens'=>$citizens,
                'faskes_id' => $faskes_id,
                'type' => $type,
                'klinik_id' => $klinik_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSearchData($citizens, $faskes_id, $type, $klinik_id, $nik)
    {
        
        $search = Yii::$app -> request->get('nik');
        $nik = $search;
        if($citizens === 'nonbadung') 
        {
                $query = 'SELECT [[noncitizen_name]] as [[nama]],[[identity_number]] as [[nik]] FROM {{noncitizen}} WHERE [[identity_number]]=:nik';
              $model = Yii::$app->db->createCommand($query, [':nik' => $nik])->queryOne();
                
        }else {
            $query = 'SELECT [[nama]],[[nik]] FROM {{citizen}} WHERE [[nik]]=:nik';
              $model = Yii::$app->db->createCommand($query, [':nik' => $nik])->queryOne();
              
        }
        
        return $this->render('search_data', [
                'model' => $model,
                'faskes_id' => $faskes_id,
                'type' => $type,
                'klinik_id' => $klinik_id
            
        ]);    
    }
    
  
    
    public function actionAdd()
    {
        $time_start = new \DateTime( date('Y-m-d 07:00:00'));
        $interval_queue = 15; // in minutes
        if(Yii::$app->request->post()) {
            $id_klinik = Yii::$app->request->post('klinik');
            $tanggal_layanan = Yii::$app->request->post('tanggal_layanan');
            $id_user = Yii::$app->request->post('nik');
            $data_klinik = \common\models\Klinik::findOne($id_klinik);
            $queryCount = "SELECT count(*) FROM `klinik_map` WHERE id_klinik=:id_klinik and tanggal=:date";
            $count = Yii::$app->db->createCommand($queryCount, [
                        ':id_klinik' => $id_klinik,
                        ':date' => $tanggal_layanan
                    ])
                    ->queryScalar();
            $next_queue = $count + 1;
            // cari pembagian
            $divisor = floor($next_queue / $data_klinik->jumlah_poli);
            // cari modulus
            $mod = $next_queue % $data_klinik->jumlah_poli;
            
            $queue_group = ($mod === 0 ? ($divisor - 1) : $divisor) * $interval_queue;
            $time_start->add(new \DateInterval('PT' . $queue_group . 'M'));
            $begin_time = $time_start->format('Y-m-d H:i:s');
            $time_start->add(new \DateInterval('PT' . $interval_queue . 'M'));
            $end_time = $time_start->format('Y-m-d H:i:s');
            $time_examination = $begin_time.' - '.$end_time;
            Yii::$app->db->createCommand()
                    ->insert('klinik_map', [
                        'id_klinik' => $id_klinik,
                        'tanggal' => $tanggal_layanan,
                        'no_antrian' => $data_klinik->kode_klinik.''.$next_queue,
                        'id_pasien' => $id_user,
                        'time_exam' => $time_examination,
                    ])->execute();
            $id = Yii::$app->db->getLastInsertID();
            return $this->redirect(['show', 'id' => $id]);
        }
        //return $this->render('menu_klinik');
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
    
    public function actionShowReservation(){
        $result = null;
         if(Yii::$app->request->isPost)
         {
             $nik = Yii::$app->request->post('nik');
             $query = "SELECT {{all_citizen}}.*, {{klinik_map}}.* FROM {{klinik_map}} 
                 INNER JOIN (SELECT [[nik]],[[nama]],[[alamat]] FROM {{citizen}} WHERE nik=:id_number
                 UNION
                select identity_number as nik, noncitizen_name as nama, address as alamat from noncitizen where identity_number=:id_number) AS {{all_citizen}}
                ON {{all_citizen}}.[[nik]] = {{klinik_map}}.[[id_pasien]] WHERE {{klinik_map}}.[[id_pasien]] = :id_number AND {{klinik_map}}.[[status]]=:status";
             $result = Yii::$app->db->createCommand($query, [':id_number' => $nik, 'status' => 1])->queryAll();
         }
        return $this->render('show_reservation', ['result' => $result] );
    }
}
