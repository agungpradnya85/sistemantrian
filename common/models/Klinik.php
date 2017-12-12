<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "klinik".
 *
 * @property integer $id
 * @property string $kode_klinik
 * @property string $nama_klinik
 * @property integer $id_faskes
 * @property integer $jumlah_poli
 *
 * @property Faskes $idFaskes
 * @property KlinikMap[] $klinikMaps
 */
class Klinik extends \yii\db\ActiveRecord
{
    public $name;
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
            [['kode_klinik', 'nama_klinik', 'id_faskes', 'jumlah_poli'], 'required'],
            [['id_faskes', 'jumlah_poli'], 'integer'],
            [['kode_klinik'], 'string', 'max' => 3],
            [['nama_klinik'], 'string', 'max' => 30],
            [['id_faskes'], 'exist', 'skipOnError' => true, 'targetClass' => Faskes::className(), 'targetAttribute' => ['id_faskes' => 'id']],
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
            'id_faskes' => 'Id Faskes',
            'jumlah_poli' => 'Jumlah Poli',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFaskes()
    {
        return $this->hasOne(Faskes::className(), ['id' => 'id_faskes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKlinikMaps()
    {
        return $this->hasMany(KlinikMap::className(), ['id_klinik' => 'id']);
    }
}
