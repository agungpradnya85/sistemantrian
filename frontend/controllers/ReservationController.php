<?php

namespace frontend\controllers;

use Yii;
use common\models\Citizen;
use common\models\NonCitizen;
use common\models\CitizenSearch;
use common\models\Klinik;
use common\models\KlinikMap;
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
        $model = new NonCitizen();

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
        // find Klinik Information
        $clinicModel = Klinik::find()->where(['id' => $klinik_id])->one();
        if($clinicModel === null)
        {
            throw new NotFoundHttpException('Halaman tidak ditemukan.');
        }
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
                'klinik_id' => $klinik_id,
                'clinicModel' => $clinicModel
            ]);    
    }
    
    public function actionAdd()
    {
        //$time_start = new \DateTime( date('Y-m-d 07:00:00'));
        
        $interval_queue = 15; // in minutes
        if(Yii::$app->request->post()) {
            $id_klinik = Yii::$app->request->post('klinik');
            $tanggal_layanan = Yii::$app->request->post('tanggal_layanan');
            $id_user = Yii::$app->request->post('nik');
            
            if($tanggal_layanan == null) {
                 echo json_encode(['error' => true, 'message' => 'Silahkan isi tanggal pelayanan']);
                die;
            }
            else if($tanggal_layanan < date('Y-m-d')) {
                 echo json_encode(['error' => true, 'message' => 'Tanggal pelayanan yang dipilih sudah lewat']);
                die;
            }
            
            $queryCheckOnePoly = "SELECT count(*) FROM klinik_map WHERE id_pasien=:id_user AND tanggal=:tanggal_layanan AND id_klinik=:id_klinik AND `status` IN (1,2)";
            $countCheckOnePoly = Yii::$app->db->createCommand($queryCheckOnePoly, [
                        ':id_user' => $id_user,
                        ':tanggal_layanan' => $tanggal_layanan,
                        ':id_klinik' => $id_klinik
                    ])
                    ->queryScalar();
            if (($countCheckOnePoly) > 0) {
                echo json_encode(['error' => true, 'message' => 'Cek kembali riwayat pesanan antrean anda']);
            }
            else {
                //inisialisasi time start
                $time_start = \DateTime::createFromFormat('Y-m-d H:i:s', "{$tanggal_layanan} 07:00:00");
                $data_klinik = Klinik::findOne($id_klinik);
                $queryCount = "SELECT count(*) FROM `klinik_map` WHERE id_klinik=:id_klinik and tanggal=:date";
                
                // query time exam start max dan jumlah antrian saat itu
                $queryCountMaxTimeStartQuery = 'SELECT id_klinik,COUNT(*) AS quota,time_exam_start  
                    FROM 
                    `klinik_map`
                        WHERE DATE(time_exam_start)=:date AND id_klinik = :id_klinik
                        GROUP BY id_klinik,time_exam_start
                        ORDER BY time_exam_start DESC LIMIT 1';

                // hitung jumlah antrian
                $count = Yii::$app->db->createCommand($queryCount, [
                            ':id_klinik' => $id_klinik,
                            ':date' => $tanggal_layanan
                        ])
                        ->queryScalar();
                
                //hitung jumlah antrian max
                $dataMaxTime = Yii::$app->db->createCommand($queryCountMaxTimeStartQuery, [
                            ':id_klinik' => $id_klinik,
                            ':date' => $tanggal_layanan
                        ])
                        ->queryOne();
                
                $next_queue = (int)$count + 1;
                
                
                /* jika tidak ada $dataMaxTime yang return array (ada data)
                 * berarti belum ada yang daftar pada saat tanggal tsb
                 */
                if(!is_array($dataMaxTime))
                {
                    $begin_time = $time_start->format('Y-m-d H:i:s');
                    $time_start->add(new \DateInterval('PT' . $interval_queue . 'M'));
                    $end_time = $time_start->format('Y-m-d H:i:s');
                }
                // jika ada
                else {
                    $saved_max_start_date = new \DateTime($dataMaxTime['time_exam_start']);
                    $saved_max_end_date =$saved_max_start_date->add(new \DateInterval('PT' . $interval_queue . 'M'));
                    
                    // jika waktu sistem > waktu max start date
                    if(date('Y-m-d H:i:s') > $saved_max_start_date->format('Y-m-d H:i:s'))
                    {
                        // cari hasil bagi dan bulatkan ke bawah
                        $divisor = floor($saved_max_start_date->format('i') / $interval_queue);
                        // pencarian minutes
                        $minutes = ((($divisor - 1)<=0) ? 0 : 1) * $interval_queue;
                        $check_start_date = new \DateTime(date('Y-m-d H:').$minutes.':00');
                        // cek jumlah kuota yang telah terisi dengan jumlah poli
                        // jika jumlah kuota yang terisi < jumlah poli
                        if($dataMaxTime['quota'] < $data_klinik->jumlah_poli)
                        {
                            $begin_time = $check_start_date->format('Y-m-d H:i:s');
                            $end_datetime = $check_start_date->add(new \DateInterval('PT' . $interval_queue . 'M'));
                            $end_time = $end_datetime->format('Y-m-d H:i:s');
                        }
                        else {
                            $start_datetime = $check_start_date->add(new \DateInterval('PT' . $interval_queue . 'M'));
                            $begin_time = $start_datetime->format('Y-m-d H:i:s');
                            $end_datetime = $start_datetime->add(new \DateInterval('PT' . $interval_queue . 'M'));
                            $end_time = $end_datetime->format('Y-m-d H:i:s');
                        }
                    }
                    else
                    {
                        // cari hasil bagi dan bulatkan ke bawah
                        $divisor = floor($saved_max_start_date->format('i') / $interval_queue);
                        // pencarian minutes
                        $minutes = ((($divisor - 1)<=0) ? 0 : 1) * $interval_queue;
                        $check_start_date = new \DateTime($saved_max_start_date->format('Y-m-d H:').$minutes.':00');
                        // cek jumlah kuota yang telah terisi dengan jumlah poli
                        // jika jumlah kuota yang terisi < jumlah poli
                        //echo $check_start_date->format('Y-m-d H:').$minutes;
                        if($dataMaxTime['quota'] < $data_klinik->jumlah_poli)
                        {
                            $begin_time = $check_start_date->format('Y-m-d H:i:s');
                            $end_datetime = $check_start_date->add(new \DateInterval('PT' . $interval_queue . 'M'));
                            $end_time = $end_datetime->format('Y-m-d H:i:s');
                            
                        }
                        else {
                            
                            $start_datetime = $check_start_date->add(new \DateInterval('PT' . $interval_queue . 'M'));
                            $begin_time = $start_datetime->format('Y-m-d H:i:s');
                            $end_datetime = $start_datetime->add(new \DateInterval('PT' . $interval_queue . 'M'));
                            $end_time = $end_datetime->format('Y-m-d H:i:s');
                        }
                    }
                }
                
                Yii::$app->db->createCommand()
                        ->insert('klinik_map', [
                            'id_klinik' => $id_klinik,
                            'tanggal' => $tanggal_layanan,
                            'no_antrian' => $data_klinik->kode_klinik.''.$next_queue,
                            'id_pasien' => $id_user,
                            'time_exam' => '-',
                            'time_exam_start' => $begin_time,
                            'time_exam_end' => $end_time
                        ])->execute();
                $id = Yii::$app->db->getLastInsertID();
                echo json_encode(['error' => false, 'message' => 'Terdaftar', 'redirect' => \yii\helpers\Url::to(['show', 'id' => $id, 'identity' => $id_user])]);
                
            //return $this->redirect(['show', 'id' => $id]);
            }
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
    public function actionShow($id, $identity)
    {
        $model = KlinikMap::find()->where([
            'id' => $id,
            'id_pasien' => $identity
        ])->one();
        if($model === null)
        {
            throw new NotFoundHttpException("Halaman tidak ditemukan.");
        }
        return $this->render('show_antrian', ['model' => $model]);
    }
    
    public function actionCancelReservation($id, $identity)
    {
            $query = "UPDATE klinik_map SET [[status]] =:status WHERE id=:id AND id_pasien=:id_pasien";
            Yii::$app->db->createCommand($query, [
                    ':status' => 0,
                    ':id' => $id,
                    ':id_pasien' => $identity
                ])
		        ->execute();
            return $this -> redirect(['/site/index']);
    }
    
    public function actionShowReservation(){
        $result = null;
         if(Yii::$app->request->isPost)
         {
             $nik = Yii::$app->request->post('nik');
             $tanggal_reservation = Yii::$app->request->post('tanggal_reservation');
            
            if(isset($tanggal_reservation) && $tanggal_reservation != null) {
                $query = "SELECT {{all_citizen}}.*, {{klinik_map}}.* FROM {{klinik_map}} 
                    INNER JOIN (SELECT [[nik]],[[nama]],[[alamat]] FROM {{citizen}} WHERE nik=:id_number
                    UNION
                    select identity_number as nik, noncitizen_name as nama, address as alamat from noncitizen where identity_number=:id_number) AS {{all_citizen}}
                    ON {{all_citizen}}.[[nik]] = {{klinik_map}}.[[id_pasien]] WHERE {{klinik_map}}.[[id_pasien]] = :id_number AND {{klinik_map}}.[[status]]=:status 
                    AND {{tanggal}} = :tanggal_reservation";
                $result = Yii::$app->db->createCommand($query, [':tanggal_reservation' => $tanggal_reservation, ':id_number' => $nik, 'status' => 1])->queryAll();
            }
             else {
                $query = "SELECT {{all_citizen}}.*, {{klinik_map}}.* FROM {{klinik_map}} 
                    INNER JOIN (SELECT [[nik]],[[nama]],[[alamat]] FROM {{citizen}} WHERE nik=:id_number
                    UNION
                    select identity_number as nik, noncitizen_name as nama, address as alamat from noncitizen where identity_number=:id_number) AS {{all_citizen}}
                    ON {{all_citizen}}.[[nik]] = {{klinik_map}}.[[id_pasien]] WHERE {{klinik_map}}.[[id_pasien]] = :id_number AND {{klinik_map}}.[[status]]=:status";
                $result = Yii::$app->db->createCommand($query, [':id_number' => $nik, 'status' => 1])->queryAll();
            }
             
            if(Yii::$app->request->isAjax)
            {
                return $this->renderPartial('_reservation_history', ['result' => $result] );
            }
        }
        return $this->render('show_reservation', ['result' => $result]);
    }
}
