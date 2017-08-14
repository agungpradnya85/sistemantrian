<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pasien".
 *
 * @property integer $id
 * @property integer $no_ktp
 * @property string $nama
 * @property string $alamat
 * @property integer $no_hp
 * @property string $username
 * @property string $password
 */
class Pasien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pasien';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_ktp', 'nama', 'alamat', 'no_hp', 'username', 'password'], 'required'],
            [['no_ktp', 'no_hp'], 'integer'],
            [['username', 'password'], 'string'],
            [['nama', 'alamat'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_ktp' => 'No Ktp',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'no_hp' => 'No Hp',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }
}
