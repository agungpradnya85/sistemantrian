<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "klinik".
 *
 * @property integer $id
 * @property string $kode_klinik
 * @property string $nama_klinik
 *
 * @property KlinikMap[] $klinikMaps
 */
class Klinik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klinik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kode_klinik', 'nama_klinik'], 'required'],
            [['id'], 'integer'],
            [['kode_klinik'], 'string', 'max' => 3],
            [['nama_klinik'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_klinik' => 'Kode Klinik',
            'nama_klinik' => 'Nama Klinik',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKlinikMaps()
    {
        return $this->hasMany(KlinikMap::className(), ['id_klinik' => 'id']);
    }
}
