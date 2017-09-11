<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "noncitizen".
 *
 * @property integer $identity_number
 * @property integer $birth_date
 * @property integer $Address
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
            [['identity_number', 'birth_date', 'Address'], 'required'],
            [['identity_number', 'birth_date', 'Address'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'identity_number' => 'Identity Number',
            'birth_date' => 'Birth Date',
            'Address' => 'Address',
        ];
    }
}
