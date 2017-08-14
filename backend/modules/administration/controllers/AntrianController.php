<?php

namespace backend\modules\administration\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AppAccessRule;

class AntrianController extends \yii\web\Controller
{
    
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
                    
                    // only role admin
                    [
                        'actions' => ['index','panggil-antrian','update-antrian',],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['rest-index'],
                        'allow' => true,
                    ],
                ],
            ],

        ];
    }
    
    public function actionIndex()
    {
        $query = 'select klinik.*, tb_latest_queue.latest_queue, 
            ifnull(tb_current_queue.current_queue,0) as current_queue from klinik 
            left join (SELECT id_klinik, max(no_antrian) as latest_queue 
                FROM `klinik_map` WHERE tanggal = :tgl) tb_latest_queue on 
                tb_latest_queue.id_klinik = klinik.id
            left join (SELECT id_klinik, max(no_antrian) as current_queue 
            FROM `klinik_map` WHERE tanggal = :tgl and status=:status_terpanggil) 
            tb_current_queue on tb_current_queue.id_klinik = klinik.id';
        
        $model = Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ':status_terpanggil' => 2
            ])->queryAll();

        return $this->render('index', ['model' => $model]);
    }
    
    public function actionRestIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = 'select klinik.*, tb_latest_queue.latest_queue, 
            ifnull(tb_current_queue.current_queue,0) as current_queue from klinik 
            left join (SELECT id_klinik, max(no_antrian) as latest_queue 
                FROM `klinik_map` WHERE tanggal = :tgl) tb_latest_queue on 
                tb_latest_queue.id_klinik = klinik.id
            left join (SELECT id_klinik, max(no_antrian) as current_queue 
            FROM `klinik_map` WHERE tanggal = :tgl and status=:status_terpanggil) 
            tb_current_queue on tb_current_queue.id_klinik = klinik.id';
        
        $model = Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ':status_terpanggil' => 2
            ])->queryOne();
        return $model;
    }


    /*
     * id adalah id klinik di tabel map_klinik;
     */
    public function actionPanggilAntrian($id)
    {
        $query = 'select * from klinik_map WHERE tanggal=:tgl AND id_klinik=:id_klinik';
        
        $model = Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ':id_klinik' => $id,
            ])->queryAll();
        return $this->render('panggil_antrian', ['model' => $model]);
    }
    
    /*
     * id adalah id si tabel klinik_map
     * status adalah field status
     */
    public function actionUpdateAntrian($id, $status, $id_klinik)
    {
        $query = "UPDATE klinik_map SET status=:status WHERE id=:id AND id_klinik=:id_klinik";
        $model = Yii::$app->db->createCommand($query, [
            ':status' => $status,
            ':id' => $id,
            ':id_klinik' => $id_klinik
        ])->execute();
        return $this->redirect(['index']);
        //return $this->redirect(['panggil-antrian', 'id' => $id_klinik]);
    }

}
