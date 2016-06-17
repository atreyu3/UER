<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Readusuario;

/**
 * ReadusuarioSearch represents the model behind the search form about `\app\models\Readusuario`.
 */
class ReadusuarioSearch extends Readusuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_readusuario', 'tbl_readusuario_antena', 'tbl_readusuario_activo'], 'integer'],
            [['tbl_readusuario_tagid', 'tbl_readusuario_timestamp', 'tbl_readusuario_rssi'], 'safe'],
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
        $query = Readusuario::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_readusuario' => $this->id_readusuario,
            'tbl_readusuario_antena' => $this->tbl_readusuario_antena,
            'tbl_readusuario_timestamp' => $this->tbl_readusuario_timestamp,
            'tbl_readusuario_activo' => $this->tbl_readusuario_activo,
        ]);

        $query->andFilterWhere(['like', 'tbl_readusuario_tagid', $this->tbl_readusuario_tagid])
            ->andFilterWhere(['like', 'tbl_readusuario_rssi', $this->tbl_readusuario_rssi]);

        return $dataProvider;
    }
}
