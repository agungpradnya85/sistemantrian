<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "citizen".
 *
 * @property string $nik
 * @property string $tipe
 * @property string $tanggal_lahir
 * @property string $kelurahan
 * @property string $nama
 * @property string $propinsi
 * @property string $kabupaten
 * @property string $kecamatan
 * @property string $alamat
 */
class Citizen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'citizen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik', 'tipe', 'tanggal_lahir', 'kelurahan', 'nama', 'propinsi', 'kabupaten', 'kecamatan', 'alamat'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['nik', 'tipe'], 'string', 'max' => 20],
            [['kelurahan', 'nama', 'propinsi', 'kabupaten', 'kecamatan', 'alamat'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'tipe' => 'Tipe',
            'tanggal_lahir' => 'Tanggal Lahir',
            'kelurahan' => 'Kelurahan',
            'nama' => 'Nama',
            'propinsi' => 'Propinsi',
            'kabupaten' => 'Kabupaten',
            'kecamatan' => 'Kecamatan',
            'alamat' => 'Alamat',
        ];
    }
}
