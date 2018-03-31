<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "klinik_konfirmasi".
 *
 * @property integer $id
 * @property string $no_antrian
 * @property integer $id_klinik
 * @property string $tipe_antrian
 * @property string $id_pasien
 * @property string $tanggal
 * @property integer $status
 */
class KlinikKonfirmasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klinik_konfirmasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_antrian', 'id_klinik', 'tipe_antrian', 'id_pasien', 'tanggal'], 'required'],
            [['id_klinik', 'status'], 'integer'],
            [['tipe_antrian'], 'string'],
            [['tanggal'], 'safe'],
            [['no_antrian'], 'string', 'max' => 11],
            [['id_pasien'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_antrian' => 'No Antrian',
            'id_klinik' => 'Id Klinik',
            'tipe_antrian' => 'Tipe Antrian',
            'id_pasien' => 'Id Pasien',
            'tanggal' => 'Tanggal',
            'status' => 'Status',
        ];
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['kiosk_validation'] = ['id_pasien','id_klinik'];//Scenario Values Only Accepted
        return $scenarios;
    }
}
