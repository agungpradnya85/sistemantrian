<?php

namespace common\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ProfileForm extends Model
{
    public $nama;
    public $alamat;
    public $no_ktp;
    public $no_hp;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'no_ktp', 'no_hp',], 'required'],
            [['nama', 'no_ktp', 'no_hp', 'alamat'], 'filter', 'filter' => 'trim'],
            ['nama', 'string', 'min' => 10, 'max' => 50],
            ['no_hp', 'match', 'pattern' => '/^\d{6,18}$/'],
            ['no_ktp', 'number']
        ];
    }

    /**
     * assign attribute label of db's fields
     */
    public function attributeLabels()
    {
        return [
            'nama' => 'Nama Lengkap',
            'no_ktp' => 'No. KTP',
            'no_hp' => 'No. HP',
            'alamat' => 'Alamat',
        ];
    }

    /**
     * Change user's profile.
     *
     * @return true the saved model or array if saving fails
     */
    public function changeProfile()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        $this->load(Yii::$app->request->post());
        if ($this->validate()) {
            $model->nama = $this->nama;
            $model->alamat = $this->alamat;
            $model->no_ktp = $this->no_ktp;
            $model->no_hp = $this->no_hp;
            $model->save();
            return true;
            //return $model->attributes;
            /*if ($model->save()) {
                return true;
            }*/
        }
        else {
            return \yii\widgets\ActiveForm::validate($this);
        }
        //return null;
    }
}
