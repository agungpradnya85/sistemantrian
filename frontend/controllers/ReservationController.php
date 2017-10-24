<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ReservationForm;
use common\models\Citizen;
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
        if(Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new ReservationForm();
            $model->load(Yii::$app->request->post());
            $validate = ActiveForm::validate($model);
            if(count($validate) > 0) {
                return ['error' => true, 'items' => $validate];
            }
            else {
                $id_klinik = $model->id_clinic;
                $tanggal_layanan = $model->arrival_date;
                $id_user = $model->identity_number;

                $reservationService = new ReservationService($id_klinik, $tanggal_layanan, $id_user);

                if($reservationService->checkIsAvailableReservation() === false)
                {
                    return ['error' => true, 'message' => 'Cek kembali riwayat pesanan antrean anda'];
                }
                else {
                    Yii::$app->db->createCommand()->insert('klinik_map', $reservationService->create())->execute();
                    $id = Yii::$app->db->getLastInsertID();
                    return ['error' => false, 'message' => 'Terdaftar', 'redirect' => \yii\helpers\Url::to(['show', 'id' => $id, 'identity' => $id_user])];
                }
            }
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
    
    public function actionShowReservation()
    {
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
