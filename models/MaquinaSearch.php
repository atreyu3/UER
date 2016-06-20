<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Maquina;

/**
 * MaquinaSearch represents the model behind the search form about `\app\models\Maquina`.
 */
class MaquinaSearch extends Maquina
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_maquina', 'tbl_marca_id_marca', 'tbl_familia_id_familia', 'tbl_maquina_activos', 'tbl_status_id_status', 'tbl_linea_id_linea', 'tbl_ubicacionfisica_id_ubicacionfisica', 'tbl_centrodecostos_id_centrodecostos'], 'integer'],
            [['tbl_maquina_bim', 'tbl_maquina_codigo', 'tbl_maquina_modelo', 'tbl_maquina_serie', 'tbl_maquina_descripcion_bim', 'tbl_maquina_descripcion', 'tbl_maquina_comentario'], 'safe'],
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
	
	public function setPerPage($recordPerPage)
    {
        Yii::$app->session->set(self::tableName().'Pagination', $recordPerPage);
    }

    public function getPerPage()
    {
        return Yii::$app->session->get(self::tableName().'Pagination', 25);
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
        $query = Maquina::find();
        $query->where(['not like','tbl_status_id_status',4]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => self::getPerPage()
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_maquina' => $this->id_maquina,
            'tbl_marca_id_marca' => $this->tbl_marca_id_marca,
            'tbl_familia_id_familia' => $this->tbl_familia_id_familia,
            'tbl_maquina_activos' => $this->tbl_maquina_activos,
            'tbl_status_id_status' => $this->tbl_status_id_status,
            'tbl_linea_id_linea' => $this->tbl_linea_id_linea,
            'tbl_ubicacionfisica_id_ubicacionfisica' => $this->tbl_ubicacionfisica_id_ubicacionfisica,
            'tbl_centrodecostos_id_centrodecostos' => $this->tbl_centrodecostos_id_centrodecostos,
        ]);

        $query->andFilterWhere(['like', 'tbl_maquina_bim', $this->tbl_maquina_bim])
            ->andFilterWhere(['like', 'tbl_maquina_codigo', $this->tbl_maquina_codigo])
            ->andFilterWhere(['like', 'tbl_maquina_modelo', $this->tbl_maquina_modelo])
            ->andFilterWhere(['like', 'tbl_maquina_serie', $this->tbl_maquina_serie])
            ->andFilterWhere(['like', 'tbl_maquina_descripcion_bim', $this->tbl_maquina_descripcion_bim])
            ->andFilterWhere(['like', 'tbl_maquina_descripcion', $this->tbl_maquina_descripcion])
            ->andFilterWhere(['like', 'tbl_maquina_comentario', $this->tbl_maquina_comentario]);

        return $dataProvider;
    }
	/**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchIniactivos($params)
    {
        $query = Maquina::find();
        $query->where(['tbl_status_id_status'=>4]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => self::getPerPage()
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_maquina' => $this->id_maquina,
            'tbl_marca_id_marca' => $this->tbl_marca_id_marca,
            'tbl_familia_id_familia' => $this->tbl_familia_id_familia,
            'tbl_maquina_activos' => $this->tbl_maquina_activos,
            'tbl_status_id_status' => $this->tbl_status_id_status,
            'tbl_linea_id_linea' => $this->tbl_linea_id_linea,
            'tbl_ubicacionfisica_id_ubicacionfisica' => $this->tbl_ubicacionfisica_id_ubicacionfisica,
            'tbl_centrodecostos_id_centrodecostos' => $this->tbl_centrodecostos_id_centrodecostos,
        ]);

        $query->andFilterWhere(['like', 'tbl_maquina_bim', $this->tbl_maquina_bim])
            ->andFilterWhere(['like', 'tbl_maquina_codigo', $this->tbl_maquina_codigo])
            ->andFilterWhere(['like', 'tbl_maquina_modelo', $this->tbl_maquina_modelo])
            ->andFilterWhere(['like', 'tbl_maquina_serie', $this->tbl_maquina_serie])
            ->andFilterWhere(['like', 'tbl_maquina_descripcion_bim', $this->tbl_maquina_descripcion_bim])
            ->andFilterWhere(['like', 'tbl_maquina_descripcion', $this->tbl_maquina_descripcion])
            ->andFilterWhere(['like', 'tbl_maquina_comentario', $this->tbl_maquina_comentario]);

        return $dataProvider;
    }
	
}
