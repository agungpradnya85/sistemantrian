<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "noncitizen".
 *
 * @property integer $identity_number
 * @property string $noncitizen_name
 * @property string $birth_date
 * @property string $address
 */
class NonCitizen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noncitizen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identity_number', 'noncitizen_name', 'birth_date', 'address'], 'required'],
            [['identity_number'], 'integer'],
            [['birth_date'], 'safe'],
            [['noncitizen_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identity_number' => 'Nomor Identitas',
            'noncitizen_name' => 'Nama',
            'birth_date' => 'Tanggal Lahir',
            'address' => 'Alamat',
        ];
    }
}
