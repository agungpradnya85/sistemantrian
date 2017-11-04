<?php

namespace api\modules\v1\controllers;

use common\models\Klinik;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\QueryParamAuth;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * Country Controller API
 *
 * @author Made Saguna <made.saguna@hotmail.com>
 */
class ClinicController extends ActiveController
{
    public $modelClass = 'common\models\Klinik';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /*public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];

        return $behaviors;
    }*/

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    protected function verbs() {
        return [
            'search' => [ 'GET' ],
        ];
    }

    public function actionIndex()
    {
        $model = Klinik::find()->select(['id', 'nama_klinik']);
        $provider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $provider;
    }

    public function actionSearch($q = null)
    {
        $results = ['id' => '', 'text' => ''];
        $query = new Query();
        $query->select(['id', 'text' => 'nama_klinik'])->from('klinik');

        if (!is_null($q)) {
            $query->where(['like', 'nama_klinik', $q]);
        }

        $query->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $results = array_values($data);

        return ['items' => $results];
    }
}


