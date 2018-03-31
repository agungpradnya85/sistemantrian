<?php

namespace frontend\modules\kiosk\controllers;

use Yii;
use frontend\models\ReservationForm;
use common\models\NonCitizen;
use common\models\CitizenSearch;
use common\models\Klinik;
use common\models\KlinikMap;
use common\models\services\ReservationService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Carbon\Carbon;
use common\models\KlinikKonfirmasi;

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

        return $this->render('@frontend/views/reservation/index', [
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
     * Creates a new Citizen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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
            return $this->render('@frontend/views/reservation/create', [
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
        if(Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new \common\models\KlinikKonfirmasi();
            $model->scenario = 'kiosk_validation';
            $model->load(Yii::$app->request->post());
            $validate = ActiveForm::validate($model);
            if(count($validate) > 0) {
                return ['error' => true, 'items' => $validate];
            }
            else {
             //$quey = 'SELECT COUNT FROM {{klinik_konfirmasi}} WHERE id_klinik = ';
                
                $klinik = Klinik::find()->where(['id' => $model->id_klinik])->one();
                $redirect = [
                    'citizen/index',
                    'faskes_id' => $klinik->id,
                    'type' => $klinik->idFaskes->tipe
                ];
                
                if($klinik->idFaskes->tipe === 'puskesmas') {
                    $redirect = array_merge($redirect, ['kecamatan_id' => $klinik->idFaskes->kecamatan0->id]);
                    
                }
                
                $query = new \yii\db\Query();
                $count = $query->from('klinik_konfirmasi')
                     ->where([
                         'id_klinik'=>$model->id_klinik,
                         'tanggal'=>date('Y-m-d'),
                         'tipe_antrian' => 'kiosk'
                      ])
                     ->count();
                
                
                $count = $count + 1;
                \Yii::$app->db->createCommand()->insert('klinik_konfirmasi', [
                    'id_pasien' => $model->id_pasien,
                    'no_antrian' => $klinik->kode_klinik.'K'.$count,
                    'id_klinik' => $model->id_klinik,
                    'tipe_antrian' => 'kiosk',
                    'tanggal' => date('Y-m-d'),
                ])->execute();;
              
            }
            return ['error' => false, 'message' => 'Terdaftar', 'redirect' => \yii\helpers\Url::to($redirect)];
        }
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
        return $this->render('@frontend/views/reservation/show_antrian', ['model' => $model]);
    }
    
    public function actionShowReservation()
    {
        $result = null;
        if(Yii::$app->request->isPost)
        {

            $nik = Yii::$app->request->post('nik');
            $tanggal_reservasi = Yii::$app->request->post('tanggal_reservation');
            $id_clinic = Yii::$app->request->post('id_clinic');
             
            $query = "SELECT {{all_citizen}}.*, {{klinik_map}}.* FROM {{klinik_map}} 
            INNER JOIN (SELECT [[nik]],[[nama]],[[alamat]] FROM {{citizen}} WHERE nik=:id_number
            UNION
            select identity_number as nik, noncitizen_name as nama, address as alamat from noncitizen where identity_number=:id_number) AS {{all_citizen}}
            ON {{all_citizen}}.[[nik]] = {{klinik_map}}.[[id_pasien]] WHERE {{klinik_map}}.[[id_pasien]] = :id_number AND {{klinik_map}}.[[status]]=:status"; 

            $bindParams = [':id_number' => $nik, 'status' => 1];

            // algoritma
            // jika tanggal_reservasi diisi
            if($tanggal_reservasi !== null) {
                $query .= " AND {{klinik_map}}.[[tanggal]] = :tanggal_reservasi";
                $bindParams[':tanggal_reservasi'] = $tanggal_reservasi;
            }

            if($id_clinic !== null) {
                $query .= " AND {{klinik_map}}.[[id_klinik]] = :clinic";
                $bindParams[':clinic'] = $id_clinic;
            }

            $result = Yii::$app->db->createCommand($query, $bindParams)->queryAll(); 
            if(Yii::$app->request->isAjax)
            {
                return $this->renderPartial('_reservation_history', ['result' => $result] );
            }
        }
        return $this->render('show_reservation', ['result' => $result]);
    }
    
     public function actionConfirmation()
    {
         //JIKA REQUEST POST
        if(Yii::$app->request->isPost)
        {
            $id_ref_number = Yii::$app->request->post('refnumber');
            $modelKlinikMap = KlinikMap::find()
                    ->where([
                        'no_antrian' => $id_ref_number,
                        'tanggal' => date('Y-m-d'),
                        'status' => 1,
                    ])
                    ->one();
           
            // jika model modelKlinikMap ada isinya
            if(isset($modelKlinikMap->id)) {
                $klinik = Klinik::find()->where(['id' => $modelKlinikMap->id_klinik])->one();
                $redirect = [
                    'citizen/index',
                    'faskes_id' => $klinik->id,
                    'type' => $klinik->idFaskes->tipe
                ];
                
                if($klinik->idFaskes->tipe === 'puskesmas') {
                    $redirect = array_merge($redirect, ['kecamatan_id' => $klinik->idFaskes->kecamatan0->id]);
                    
                }
                //var_dump("faskes_id={$klinik->id}&type={$klinik->idFaskes->tipe}&kecamatan_id={$klinik->idFaskes->kecamatan0->id}");
                \Yii::$app->db->createCommand()->insert('klinik_konfirmasi', [
                       'id_pasien' => $modelKlinikMap->id_pasien,
                       'no_antrian' => $modelKlinikMap->no_antrian,
                       'id_klinik' => $modelKlinikMap->id_klinik,
                       'tipe_antrian' => 'online',
                       'tanggal' => $modelKlinikMap->tanggal,
                   ])->execute();
                
                $query = "UPDATE klinik_map SET [[status]] =:status WHERE id=:id AND id_pasien=:id_pasien";
                Yii::$app->db->createCommand($query, [
                        ':status' => 2,
                        ':id' => $modelKlinikMap->id,
                        ':id_pasien' => $modelKlinikMap->id_pasien
                    ])
                    ->execute();
                //var_dump($redirect);
                $this->redirect($redirect);
            }else {
               echo("Antrian anda tidak terdaftar");
            }
        }
        else {
            return $this->render('confirmation');
        }
    }
}
