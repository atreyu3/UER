<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Devoluciones;

/**
 * DevolucionesSearch represents the model behind the search form about `\app\models\Devoluciones`.
 */
class DevolucionesSearch extends Devoluciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_devolucion', 'mod_transaccionrefaccion_id_transaccionrefaccion', 'tbl_user_id_user','tbl_item_id_item'], 'integer'],
            [['tbl_devolucion_tagid', 'tbl_devolucion_date'], 'safe'],
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
        $query = Devoluciones::find();
		$query->select(['tbl_item_id_item','tbl_devolucion_date,tbl_user_id_user,Sum(tbl_devolucion_cantidad) as sumacount']);
		$query->groupBy(['tbl_devolucion_date','tbl_item_id_item'])->all();
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
            'id_devolucion' => $this->id_devolucion,
            'mod_transaccionrefaccion_id_transaccionrefaccion' => $this->mod_transaccionrefaccion_id_transaccionrefaccion,
            'tbl_user_id_user' => $this->tbl_user_id_user,
            'tbl_devolucion_date' => $this->tbl_devolucion_date,
            'tbl_item_id_item'=>$this->tbl_item_id_item
        ]);

        $query->andFilterWhere(['like', 'tbl_devolucion_tagid', $this->tbl_devolucion_tagid]);

        return $dataProvider;
    }
}
