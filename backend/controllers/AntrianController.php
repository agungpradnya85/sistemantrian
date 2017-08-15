<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AntrianController extends Controller
{
    /**
     * Untuk Lihat Antrian berdasarkan id klinik
     * @param int $id (id adalah id_klinik)
     */
    public function actionShowAntrian($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $query = 'select klinik.*, tb_latest_queue.latest_queue, 
            ifnull(tb_current_queue.current_queue,0) as current_queue from klinik 
            left join (SELECT id_klinik, max(no_antrian) as latest_queue 
                FROM `klinik_map` WHERE tanggal = :tgl) tb_latest_queue on 
                tb_latest_queue.id_klinik = klinik.id
            left join (SELECT id_klinik, max(no_antrian) as current_queue 
            FROM `klinik_map` WHERE tanggal = :tgl and status=:status_terpanggil) 
            tb_current_queue on tb_current_queue.id_klinik = klinik.id where klinik.id=:id_klinik';
        
        $model = Yii::$app->db->createCommand($query, [
            ':tgl' => date('Y-m-d'),
            ':status_terpanggil' => 2,
            ':id_klinik' => $id
            ])->queryOne();
        return($model);
    }
}