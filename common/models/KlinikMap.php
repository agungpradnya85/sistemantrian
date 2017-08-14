<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "klinik_map".
 *
 * @property integer $id
 * @property integer $no_antrian
 * @property integer $id_klinik
 * @property integer $id_pasien
 * @property string $tanggal
 */
class KlinikMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klinik_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_antrian', 'id_klinik', 'id_pasien', 'tanggal'], 'required'],
            [['no_antrian', 'id_klinik', 'id_pasien'], 'integer'],
            [['tanggal'], 'safe'],
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
            'id_pasien' => 'Id Pasien',
            'tanggal' => 'Tanggal',
        ];
    }
}
