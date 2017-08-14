<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\KlinikMap;

/**
 * KlinikMapSearch represents the model behind the search form about `common\models\KlinikMap`.
 */
class KlinikMapSearch extends KlinikMap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'no_antrian', 'id_klinik', 'id_pasien'], 'integer'],
            [['tanggal'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = KlinikMap::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'no_antrian' => $this->no_antrian,
            'id_klinik' => $this->id_klinik,
            'id_pasien' => $this->id_pasien,
            'tanggal' => $this->tanggal,
        ]);

        return $dataProvider;
    }
}
