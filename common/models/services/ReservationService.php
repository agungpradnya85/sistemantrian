<?php

/*
 * Created by Made Saguna <madesaguna@users.noreply.github.com>
 * Service class for reservation
 */

namespace common\models\services;

use Yii;
use common\models\Klinik;
use Carbon\Carbon;

class ReservationService
{
    const INTERVAL_QUEUE_TIME = 15;
    public $clinic_id;
    public $departure_date;
    public $identity_number;

    public function __construct($clinic_id, $departure_date, $identity_number)
    {
        $this->clinic_id = $clinic_id;
        $this->departure_date = $departure_date;
        $this->identity_number = $identity_number;
    }

    /* check user telah melakukan reservasi pada tanggal dan poli tertentu */
    public function checkIsAvailableReservation()
    {
        $query = "SELECT count(*) FROM klinik_map WHERE id_pasien=:id_user AND tanggal=:tanggal_layanan AND id_klinik=:id_klinik AND `status` IN (1,2)";
        $count = Yii::$app->db->createCommand($query, [
            ':id_user' => $this->identity_number,
            ':tanggal_layanan' => $this->departure_date,
            ':id_klinik' => $this->clinic_id,
        ])
        ->queryScalar();
        // jika result count > 0, maka user telah melakukan reservasi, sehingga di set false
        return ($count > 0) ? false : true;
    }

    public function calculateClinicQueue()
    {
        $query = "SELECT count(*) FROM `klinik_map` WHERE id_klinik=:id_klinik and tanggal=:date";
        // hitung jumlah antrian
        $count = Yii::$app->db->createCommand($query, [
            ':id_klinik' => $this->clinic_id,
            ':date' => $this->departure_date,
        ])
        ->queryScalar();
        return $count;
    }

    public function calculateMaxClinicQueue()
    {
        // query time exam start max dan jumlah antrian saat itu
        $query = 'SELECT id_klinik,COUNT(*) AS quota,time_exam_start  
        FROM 
        `klinik_map`
            WHERE DATE(time_exam_start)=:date AND id_klinik = :id_klinik
            GROUP BY id_klinik,time_exam_start
            ORDER BY time_exam_start DESC LIMIT 1';
    
        //hitung jumlah antrian max
        $count = Yii::$app->db->createCommand($query, [
                ':id_klinik' => $this->clinic_id,
                ':date' => $this->departure_date,
            ])
            ->queryOne();
        return $count;
    }

    public function create()
    {
        
        //inisialisasi time start
        $time_start = Carbon::createFromFormat('Y-m-d H:i:s', "{$this->departure_date} 07:00:00");
        $data_klinik = Klinik::findOne($this->clinic_id);
        
        $count = $this->calculateClinicQueue();
        $dataMaxTime = $this->calculateMaxClinicQueue();
        $next_queue = (int)$count + 1;
            
        /* jika tidak ada $dataMaxTime yang return array (ada data)
         * berarti belum ada yang daftar pada saat tanggal tsb
         */
        if(!is_array($dataMaxTime))
        {
            if($this->departure_date > date('Y-m-d'))
            {
                $begin_time = $time_start->toDateTimeString();
                $end_time = $time_start->copy()->addMinutes(self::INTERVAL_QUEUE_TIME)->toDateTimeString();
            }
            else
            {
                $time_start = Carbon::now();
                $check_start_date = $this->getStartDate($time_start);
                $begin_time = $check_start_date->toDateTimeString();
                $timeRange = $this->getTimeRange($check_start_date);
                $begin_time = $timeRange['begin'];
                $end_time = $timeRange['end'];
            }
            
        }
        // jika ada
        else {
            $saved_max_start_date = Carbon::createFromFormat('Y-m-d H:i:s', $dataMaxTime['time_exam_start']);
            $saved_max_end_date = $saved_max_start_date->copy()->addMinutes(self::INTERVAL_QUEUE_TIME);
            
            // jika waktu sistem > waktu max start date
            $check_start_date = (date('Y-m-d H:i:s') > $saved_max_start_date->format('Y-m-d H:i:s')) ? $this->getStartDate($saved_max_start_date, true) : $this->getStartDate($saved_max_start_date);

            // cek jumlah kuota yang telah terisi dengan jumlah poli
            // jika jumlah kuota yang terisi < jumlah poli
            $start_datetime = ($dataMaxTime['quota'] < $data_klinik->jumlah_poli) ? $check_start_date->copy() : $check_start_date->copy()->addMinutes(self::INTERVAL_QUEUE_TIME);
            
            $timeRange = $this->getTimeRange($start_datetime);
            $begin_time = $timeRange['begin'];
            $end_time = $timeRange['end'];
        }
            
        return [
            'id_klinik' => $this->clinic_id,
            'tanggal' => $this->departure_date,
            'no_antrian' => $data_klinik->kode_klinik.''.$next_queue,
            'id_pasien' => $this->identity_number,
            'time_exam' => '-',
            'time_exam_start' => $begin_time,
            'time_exam_end' => $end_time
        ];   
    }

    private function getStartDate($dateTime, $currentTime = false)
    {
        // cari hasil bagi dan bulatkan ke bawah
        $_dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime->toDateTimeString());
        $divisor = floor($_dateTime->format('i') / self::INTERVAL_QUEUE_TIME);
        // pencarian minutes
        $minutes = ($divisor) * self::INTERVAL_QUEUE_TIME;
        $_dateTime->minute = $minutes;
        $_dateTime->second = 0;
        if($currentTime === true)
        {
            $_dateTime->year = date('Y');
            $_dateTime->month = date('m');
            $_dateTime->day = date('d');
            $_dateTime->hour = date('H');
        }
        return $_dateTime;
    }

    private function getTimeRange($startDate)
    {
        $begin_time = $startDate->toDateTimeString();
        $end_time = $startDate->copy()->addMinutes(self::INTERVAL_QUEUE_TIME)->toDateTimeString();
        return ['begin' => $begin_time, 'end' => $end_time];
    }

    /*public function saveData()
    {
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
    }*/
}