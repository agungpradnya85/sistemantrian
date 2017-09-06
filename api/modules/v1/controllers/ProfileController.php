<?php

namespace api\modules\v1\controllers;

use Yii;
use common\models\User;
use common\models\PasswordForm;
use common\models\ProfileForm;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\QueryParamAuth;
use yii\db\Query;

/**
 * Country Controller API
 *
 * @author Made Saguna <made.saguna@hotmail.com>
 */
class ProfileController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    protected function verbs() {
        return [
            'search' => [ 'GET' ],
            //'update' => ['POST'],
        ];
    }

    public function actionIndex()
    {
        $model = User::find()->select(['id', 'username'])->where(['id' => Yii::$app->user->identity->id])->one();
       
        return $model;
    }
    
    public function actionUpdate()
    {
        $model = new ProfileForm;
        $result = $model->changeProfile();
        if($result === true) {
            return ['message' => 'success', 'error' => false];
        }
        else {
            return ['error' => true, 'message' => $result];
        }
        
        /*$model = new ProfileForm;
        $modelUser = User::findOne(Yii::$app->user->identity->id);
        $model->load(Yii::$app->request->post());
        $errors = \yii\widgets\ActiveForm::validate($model);

        if(count($errors) === 0) {
            $modelUser->nama = $model->nama;
            $modelUser->alamat = $model->alamat;
            $modelUser->no_ktp = $model->no_ktp;
            $modelUser->no_hp = $model->no_hp;
            $modelUser->save();
        }
        else{
            $result['error'] = true;
            $result['message'] = $errors;
        }
        return $result;*/

    }

    public function actionChangePassword()
    {
        $model = new PasswordForm;
        $modelUser = User::findOne(Yii::$app->user->identity->id);
        $result = ['message' => 'success', 'error' => false];

        $model->load(Yii::$app->request->post());
        $errors = \yii\widgets\ActiveForm::validate($model);

        if(count($errors) === 0) {
             $modelUser->password = $model->newpass;
             $modelUser->generateAuthKey();
             $modelUser->save();
        }
        else{
            $result['error'] = true;
            $result['message'] = $errors;
        }
        return $result;
    }
}


