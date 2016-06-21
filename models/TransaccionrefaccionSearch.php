<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaccionrefaccion;

/**
 * TransaccionrefaccionSearch represents the model behind the search form about `app\models\Transaccionrefaccion`.
 */
class TransaccionrefaccionSearch extends Transaccionrefaccion
{
	public $Linea;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_transaccionrefaccion', 'tbl_maquina_id_maquina','tbl_usorefaccion_id_usorefaccion', 'tbl_item_id_item', 'tbl_user_id_user'], 'integer'],
            [['id_lineaprovisional','mod_transaccionrefaccion_date', 'mod_transaccionrefaccion_piezas'], 'safe'],
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
    	
        $query = Transaccionrefaccion::find();
		$query->select(['id_transaccionrefaccion','tbl_item_id_item','mod_transaccionrefaccion_date,tbl_maquina_id_maquina,tbl_user_id_user,tbl_usorefaccion_id_usorefaccion,Sum(mod_transaccionrefaccion_piezas) as sumacount']);
		$query->groupBy(['mod_transaccionrefaccion_date','tbl_item_id_item'])->all();
		$query->joinWith(['tblMaquinaIdMaquina']);
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
            'id_transaccionrefaccion' => $this->id_transaccionrefaccion,
            'tbl_maquina_id_maquina' => $this->tbl_maquina_id_maquina,
            'tbl_usorefaccion_id_usorefaccion' => $this->tbl_usorefaccion_id_usorefaccion,
            'tbl_item_id_item' => $this->tbl_item_id_item,
            'tbl_user_id_user' => $this->tbl_user_id_user,
        ]);
		if(isset($this->mod_transaccionrefaccion_date)){
		$dates=explode('to',$this->mod_transaccionrefaccion_date);
		if(isset($dates[1])){	
		$query->andFilterWhere(['BETWEEN','mod_transaccionrefaccion.mod_transaccionrefaccion_date', $dates[0],$dates[1]]);
			}
		}
        $query->andFilterWhere(['like', 'mod_transaccionrefaccion_piezas', $this->mod_transaccionrefaccion_piezas]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_louder', $this->mod_transaccionrefaccion_louder]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_confirmacion', $this->mod_transaccionrefaccion_piezas]);

        return $dataProvider;
    }
	 /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchsinregistrar($params)
    {
    	
        $query = Transaccionrefaccion::find();
		$query->select(['id_transaccionrefaccion','tbl_item_id_item','mod_transaccionrefaccion_date,tbl_maquina_id_maquina,tbl_user_id_user,tbl_usorefaccion_id_usorefaccion,Sum(mod_transaccionrefaccion_piezas) as sumacount']);
		$query->where(['tbl_maquina_id_maquina'=>0,'tbl_usorefaccion_id_usorefaccion'=>0]);		
		$query->groupBy(['mod_transaccionrefaccion_date','tbl_item_id_item'])->all();
		$query->joinWith(['tblMaquinaIdMaquina']);
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
            'id_transaccionrefaccion' => $this->id_transaccionrefaccion,
            'tbl_maquina_id_maquina' => $this->tbl_maquina_id_maquina,
            'tbl_usorefaccion_id_usorefaccion' => $this->tbl_usorefaccion_id_usorefaccion,
            'tbl_item_id_item' => $this->tbl_item_id_item,
            'tbl_user_id_user' => $this->tbl_user_id_user,
        ]);
		if(isset($this->mod_transaccionrefaccion_date)){
		$dates=explode('to',$this->mod_transaccionrefaccion_date);
		if(isset($dates[1])){	
		$query->andFilterWhere(['BETWEEN','mod_transaccionrefaccion.mod_transaccionrefaccion_date', $dates[0],$dates[1]]);
			}
		}
        $query->andFilterWhere(['like', 'mod_transaccionrefaccion_piezas', $this->mod_transaccionrefaccion_piezas]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_louder', $this->mod_transaccionrefaccion_louder]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_confirmacion', $this->mod_transaccionrefaccion_piezas]);

        return $dataProvider;
    }
	public function searchreporte($params)
    {
        $query = Transaccionrefaccion::find();
		 $subQuery = Devoluciones::find()
         ->select ('mod_transaccionrefaccion_id_transaccionrefaccion')                     // would prefer to write: select (1) 
         ->where("mod_transaccionrefaccion_id_transaccionrefaccion = {{" . Devoluciones::tableName() . "}}.[[mod_transaccionrefaccion_id_transaccionrefaccion]]");
		$query->joinWith(['tblMaquinaIdMaquina']);
		$query->joinWith(['tblDevoluciones']);
		
		$query->select(['tbl_item_id_item','mod_transaccionrefaccion_date','tbl_maquina_id_maquina','Sum(mod_transaccionrefaccion_piezas) as sumacount']);
		$query->where(['NOT EXISTS',$subQuery]);
		$query->groupBy(['tbl_maquina_id_maquina','tbl_item_id_item'])->all();
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
            'id_transaccionrefaccion' => $this->id_transaccionrefaccion,
            'tbl_maquina_id_maquina' => $this->tbl_maquina_id_maquina,
            'tbl_usorefaccion_id_usorefaccion' => $this->tbl_usorefaccion_id_usorefaccion,
            'tbl_item_id_item' => $this->tbl_item_id_item,
            'tbl_user_id_user' => $this->tbl_user_id_user,
            'tbl_linea_id_linea'=> $this->id_lineaprovisional,
        ]);
		if(isset($this->mod_transaccionrefaccion_date)){
		$dates=explode('to',$this->mod_transaccionrefaccion_date);
		if(isset($dates[1])){	
		$query->andFilterWhere(['BETWEEN','mod_transaccionrefaccion.mod_transaccionrefaccion_date', $dates[0],$dates[1]]);
			}
		}
		
	    $query->andFilterWhere(['like', 'mod_transaccionrefaccion_piezas', $this->mod_transaccionrefaccion_piezas]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_louder', $this->mod_transaccionrefaccion_louder]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_confirmacion', $this->mod_transaccionrefaccion_piezas]);

        return $dataProvider;
    }
	public function searchreportejecutivo($params)
    {
        $query = Transaccionrefaccion::find();
		 $subQuery = Devoluciones::find()
         ->select ('mod_transaccionrefaccion_id_transaccionrefaccion')                     // would prefer to write: select (1) 
         ->where("mod_transaccionrefaccion_id_transaccionrefaccion = {{" . Devoluciones::tableName() . "}}.[[mod_transaccionrefaccion_id_transaccionrefaccion]]");
		$query->joinWith(['tblMaquinaIdMaquina']);
		$query->joinWith(['tblDevoluciones']);
		
		$query->select(['tbl_item_id_item','mod_transaccionrefaccion_date','tbl_maquina_id_maquina','Sum(mod_transaccionrefaccion_piezas) as sumacount']);
		$query->where(['NOT EXISTS',$subQuery]);
		$query->groupBy(['tbl_maquina_id_maquina','tbl_item_id_item'])->all();
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
            'id_transaccionrefaccion' => $this->id_transaccionrefaccion,
            'tbl_maquina_id_maquina' => $this->tbl_maquina_id_maquina,
            'tbl_usorefaccion_id_usorefaccion' => $this->tbl_usorefaccion_id_usorefaccion,
            'tbl_item_id_item' => $this->tbl_item_id_item,
            'tbl_user_id_user' => $this->tbl_user_id_user,
            'tbl_linea_id_linea'=> $this->id_lineaprovisional,
        ]);
		if(isset($this->mod_transaccionrefaccion_date)){
		$dates=explode('to',$this->mod_transaccionrefaccion_date);
		if(isset($dates[1])){	
		$query->andFilterWhere(['BETWEEN','mod_transaccionrefaccion.mod_transaccionrefaccion_date', $dates[0],$dates[1]]);
			}
		}
		
	    $query->andFilterWhere(['like', 'mod_transaccionrefaccion_piezas', $this->mod_transaccionrefaccion_piezas]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_louder', $this->mod_transaccionrefaccion_louder]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_confirmacion', $this->mod_transaccionrefaccion_piezas]);

        return $dataProvider;
    }
	public function searchreportelinea($params)
    {
        $query = Transaccionrefaccion::find();
		 $subQuery = Devoluciones::find()
         ->select ('mod_transaccionrefaccion_id_transaccionrefaccion')                     // would prefer to write: select (1) 
         ->where("mod_transaccionrefaccion_id_transaccionrefaccion = {{" . Devoluciones::tableName() . "}}.[[mod_transaccionrefaccion_id_transaccionrefaccion]]");
		
		 $subQuery2 = Item::find()
         ->select ('id_item')->from([Item::tableName(),Precio::tableName()])                     
         ->where("tbl_item_id_item = {{" . Item::tableName() . "}}.[[id_item]] And ".Precio::tableName().".[[tbl_precio_opcion]]=1");
		$query->joinWith(['tblMaquinaIdMaquina']);
		$query->joinWith(['tblDevoluciones']);
		$query->select(['tbl_item_id_item','mod_transaccionrefaccion_date','tbl_maquina_id_maquina','Sum(tbl_precio_precio) as sumacount']);
		$query->where(['NOT EXISTS',$subQuery]);
		$query->andFilterWhere(['EXISTS',$subQuery2]);
		$query->groupBy(['tbl_maquina_id_maquina','tbl_item_id_item'])->all();
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
            'id_transaccionrefaccion' => $this->id_transaccionrefaccion,
            'tbl_maquina_id_maquina' => $this->tbl_maquina_id_maquina,
            'tbl_usorefaccion_id_usorefaccion' => $this->tbl_usorefaccion_id_usorefaccion,
            'tbl_item_id_item' => $this->tbl_item_id_item,
            'tbl_user_id_user' => $this->tbl_user_id_user,
            'tbl_linea_id_linea'=> $this->id_lineaprovisional,
        ]);
		if(isset($this->mod_transaccionrefaccion_date)){
		$dates=explode('to',$this->mod_transaccionrefaccion_date);
		if(isset($dates[1])){	
		$query->andFilterWhere(['BETWEEN','mod_transaccionrefaccion.mod_transaccionrefaccion_date', $dates[0],$dates[1]]);
			}
		}
		
	    $query->andFilterWhere(['like', 'mod_transaccionrefaccion_piezas', $this->mod_transaccionrefaccion_piezas]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_louder', $this->mod_transaccionrefaccion_louder]);
		$query->andFilterWhere(['like', 'mod_transaccionrefaccion_confirmacion', $this->mod_transaccionrefaccion_piezas]);

        return $dataProvider;
    }
}
