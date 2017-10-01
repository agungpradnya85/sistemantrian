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
                        'roles' => ['admin', 'operator'],
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
        $user = Yii::$app->user->identity;
        
        /*$query = 'select klinik.*, tb_latest_queue.latest_queue, 
            ifnull(tb_current_queue.current_queue,0) as current_queue from klinik 
            left join (SELECT id_klinik, max(no_antrian) as latest_queue 
                FROM `klinik_map` WHERE tanggal = :tgl GROUP BY id_klinik,tanggal) tb_latest_queue on 
                tb_latest_queue.id_klinik = klinik.id
            left join (SELECT id_klinik, max(no_antrian) as current_queue 
            FROM `klinik_map` WHERE tanggal = :tgl and status=:status_terpanggil GROUP BY id_klinik,tanggal) 
            tb_current_queue on tb_current_queue.id_klinik = klinik.id';
        
        if($user->role === 'operator')
        {
            $query .= " WHERE id_faskes = '".$user->faskes_access."'";
        }*/
        
        
        
        if($user->role === 'operator')
        {
            $query = "SELECT klinik.nama_klinik,klinik.id,klinik_map.no_antrian FROM klinik_map 
INNER JOIN klinik ON klinik.id= klinik_map.id_klinik AND klinik.id_faskes=:id_faskes
WHERE klinik_map.tanggal=:tgl
ORDER BY klinik_map.id ASC";
            
            $model = Yii::$app->db->createCommand($query, [
                ':tgl' => date('Y-m-d'),
                ':id_faskes' => $user->faskes_access
            ])->queryAll();
        }
        else {
            $query = "SELECT klinik.nama_klinik,klinik.id,klinik_map.no_antrian FROM klinik_map 
INNER JOIN klinik ON klinik.id= klinik_map.id_klinik
WHERE klinik_map.tanggal=:tgl
ORDER BY klinik_map.id ASC";
            
            $model = Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ])->queryAll();
        }
        
      /*  var_dump(Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ':status_terpanggil' => 2
            ])->rawSql);*/
        $results = [];
        foreach($model as $iterasi) {
            $results[$iterasi['id']][] = [
                'nama_klinik' => $iterasi['nama_klinik'],
                'id_klinik' => $iterasi['id'],
                'no_antrian' => $iterasi['no_antrian']
            ];
        }
        
         //var_dump($model);die;
        return $this->render('index', ['model' => $results]);
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
        $klinik = \common\models\Klinik::findOne($id);
        $query = 'SELECT * FROM klinik_map LEFT JOIN
(SELECT * FROM (SELECT nik,nama FROM citizen
UNION 
SELECT identity_number AS nik, noncitizen_name AS nama FROM noncitizen) AS g) AS all_citizen ON all_citizen.nik=klinik_map.id_pasien
WHERE tanggal=:tgl AND id_klinik=:id_klinik ';
        
        $model = Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ':id_klinik' => $id,
            ])->queryAll();
        return $this->render('panggil_antrian', ['model' => $model,'klinik' => $klinik]);
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
