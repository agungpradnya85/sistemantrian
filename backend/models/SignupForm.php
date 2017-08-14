<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    //public $email;
    public $password;
    public  $nama;
     public  $no_hp;
      public  $alamat;
       public  $no_ktp;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['nama', 'no_ktp', 'alamat', 'no_hp'], 'required'],
            ['nama', 'string', 'max' => 244],
            [['no_hp', 'no_ktp'], 'string', 'min' => 10, 'max' => 19],
            [['alamat'] , 'string', 'max' => 90],
            //['email', 'trim'],
            //['email', 'required'],
            //['email', 'email'],
            //['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        //$user->email = $this->email;
        $user->nama = $this->nama;
        $user->alamat = $this->alamat;
        $user->no_hp = $this->no_hp;
        $user->no_ktp = $this->no_ktp;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
