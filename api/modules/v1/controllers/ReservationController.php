<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\KlinikMap;
use common\models\KlinikMapSearch;
use common\models\Klinik;
use yii\rest\Controller;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * ReservasiController implements the CRUD actions for KlinikMap model.
 */
class ReservationController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        
        /*$behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];*/
    
        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    protected function verbs()
    {
        return [
            //'search' => [ 'GET' ],
            //'index' => ['GET', 'HEAD'],
            //'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'cancel-reservation' => ['POST'],
            //'show' => ['POST'],
            //'delete' => ['DELETE'],
        ];
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
        }else if($antrian >= 37 && $antrian <= 48)
        {
            $timeExamination = '14.00 - 16.00';
        }else if($antrian >= 49 && $antrian <= 60)
        {
            $timeExamination = '16.00 - 18.00';
        }
        
        
        return $timeExamination;
    }

    public function actionCreate()
    {
        $id_user = Yii::$app->user->identity->id;
        $id_klinik = Yii::$app->request->post('id_klinik');
        $data_klinik = Klinik::findOne($id_klinik);
        $queryCount = "SELECT count(*) FROM `klinik_map` WHERE id_klinik=:id_klinik and tanggal=:date";
        $count = Yii::$app->db->createCommand($queryCount, [
                    ':id_klinik' => $id_klinik,
                    ':date' => date('Y-m-d')
                ])
                ->queryScalar();
        $next_queue = $count + 1;
        $timeExamination = $this->showTimeExamination($next_queue);
       
        Yii::$app->db->createCommand()
                ->insert('klinik_map', [
                    'id_klinik' => $id_klinik,
                    'tanggal' => date('Y-m-d'),
                    'no_antrian' => $data_klinik->kode_klinik.''.$next_queue,
                    'id_pasien' => $id_user,
                    'time_exam' => $timeExamination,
                ])->execute();

        return [
            'no_antrian' => $data_klinik->kode_klinik.$next_queue,
            'id_antrian' => Yii::$app->db->getLastInsertID(),
            'id_klinik' => $id_klinik,
            'nama_klinik' => $data_klinik->nama_klinik,
            'time_exam' => $timeExamination,
            'id_user' => $id_user
        ];

    }
    
    // membatalkan reservasi
    // android
    public function actionCancelReservation()
    {
        if(Yii::$app->request->post()) {
            $id_user = Yii::$app->user->identity->id;
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

}
