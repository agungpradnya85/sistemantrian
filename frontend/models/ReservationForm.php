<?php

namespace frontend\models;

use yii\base\Model;

class ReservationForm extends Model
{
    public $id_clinic;
    public $arrival_date;
    public $identity_number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_clinic', 'arrival_date', 'identity_number'], 'required'],
            [['identity_number', 'id_clinic'], 'integer'],
            ['arrival_date', 'date', 'format' => 'php:Y-m-d'],
            ['arrival_date', 'checkDate'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'identity_number' => 'Nomor Identitas',
            'arrival_date' => 'Tanggal Layanan',
            'id_clinic' => 'Klinik',
        ];
    }

    public function checkDate($attribute, $params)
    {
        if($this->$attribute < date('Y-m-d')) {
            $this->addError($attribute, 'Tanggal Layanan yang anda pilih telah lewat');
        }
    }
}
