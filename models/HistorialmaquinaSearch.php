<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Historialmaquina;

/**
 * HistorialmaquinaSearch represents the model behind the search form about `\app\models\Historialmaquina`.
 */
class HistorialmaquinaSearch extends Historialmaquina
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historialmaquina', 'tbl_maquina_id_maquina'], 'integer'],
            [['tbl_historialmaquina_antes', 'tbl_historialmaquina_despues', 'tbl_historialmaquina_cambio', 'tbl_historialmaquina_date', 'tbl_historialmaquina_usuario'], 'safe'],
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
        $query = Historialmaquina::find();

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
            'id_historialmaquina' => $this->id_historialmaquina,
            'tbl_historialmaquina_date' => $this->tbl_historialmaquina_date,
            'tbl_maquina_id_maquina' => $this->tbl_maquina_id_maquina,
        ]);

        $query->andFilterWhere(['like', 'tbl_historialmaquina_antes', $this->tbl_historialmaquina_antes])
            ->andFilterWhere(['like', 'tbl_historialmaquina_despues', $this->tbl_historialmaquina_despues])
            ->andFilterWhere(['like', 'tbl_historialmaquina_cambio', $this->tbl_historialmaquina_cambio])
            ->andFilterWhere(['like', 'tbl_historialmaquina_usuario', $this->tbl_historialmaquina_usuario]);

        return $dataProvider;
    }
}
