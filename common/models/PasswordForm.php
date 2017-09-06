<?php

namespace common\models;

use Yii;
use yii\base\Model;

/* taken from http://mumunotesss.blogspot.co.id/2015/06/change-password-with-validation-and.html */
class PasswordForm extends Model
{
    public $newpass;
    public $repeatnewpass;

    public function rules() {
        return [
            [['newpass', 'repeatnewpass'], 'required'],
            ['repeatnewpass', 'compare', 'compareAttribute' => 'newpass'],
        ];
    }

    public function attributeLabels() {
        return [
            'newpass' => 'Password Baru',
            'repeatnewpass' => 'Ulangi Password Baru',
        ];
    }

}