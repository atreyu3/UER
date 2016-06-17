<?php
 /* 
 *//**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/* humberto codegenerator*/
use yii\helpers\ArrayHelper;
/* humberto codegenerator*/

<?php $col=0;?>
/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
	<?php if($col==0) $id=$column->name;?>
	<?php if($col==1) $primercolum=$column->name;?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
 	<?php $col++; ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= substr($relation[1], 3) . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>

<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>
    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?php 
        $a=explode(",", $relation[0]);
		$b=explode("::", $a[0]);
		$c=explode("(", $b[0]);
		echo $c[0]."(".substr($c[1], 3)."::className(),".$a[1];
		if (isset($a[2])) echo ",".$a[2]." \n";
		else echo " \n";
         //$relation[0] . "\n" ?>
    }
    <?php if($relation[2]!=1):?>
    <?php 
    $namelist="";
    $namelist=strtolower(substr($relation[1], 0,3)."_".substr($relation[1],3));  
	$namelists=Yii::$app->db->getTableSchema($namelist);
		if(isset($namelists)):?>
	/**
     * humberto code  
     */
	<?php $list=$namelists->getColumnNames();?>
	public function get<?= $relation[1] ?>List()
    {
          return ArrayHelper::map(<?= substr($relation[1], 3) ?>::find()->all(),'<?= $list[0] ?>','<?= $list[1] ?>'); 
    }	
		<?php endif; ?>
	<?php endif;?>
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
	public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) {
    		$this-><?= $primercolum ?>=ucfirst(strtolower(trim($this-><?= $primercolum ?>)));
            return true;
    } else {
        return false;
    }
	}
	public function checkname($string){
		return $this->find()->select('<?= $id ?>')->where(['<?= $primercolum ?>'=>$string])->column() != false ? $this->find()->select('<?= $id ?>')->where(['<?= $primercolum ?>'=>$string])->column() : false;
	}
	public function cargacsv($carga){
	$a=array();
	$b=array();
	$archivo=Archivo::findOne($carga['id']);
	$bandera=true;
	$csvcolumn=0;
	foreach ($carga['modelcsv'] as $envia=>$key) {
		$a[$envia]=$key;	
		}
	$csvlines=$archivo->proccessall();	
	foreach ( as $csvline) {
		$row=0;
		$modelo= new <?= $className ?>();
		$bandera=true;
		foreach ($this->attributes() as $k=>$key) {
			if($row==0)$modelnombre=$this->nombre($key);
			if($row>0){
				if($this->nombre($key)==$modelnombre){
				$modelo->$key=$csvline[$a[$key]];
				}else{
				if($rela=$this->checkrelation($key,$csvline[$a[$key]]))
				$modelo->$key=$rela[0];
				else{
				$bandera=false;
				$b[$key][$csvcolumn]=$csvline[$a[$key]];
				}	
				}
			}
			$row++;
		}
			if($bandera==true){
			$csvcolumn++;
			$modelo->save();
			}
		}
		$b['columnasadd']=$csvcolumn;
	 return $b;
	 }
	protected function nombre($string){
		$string=explode("_", $string);
		return ucfirst(strtolower(trim($string[1])));
	}

	protected function checkrelation($relacion,$csvcolumna){
		$relacionmodelo= ucfirst($this->nombre($relacion));
		<?php foreach ($relations as $name => $relation): ?>
 if($relacionmodelo=="<?= substr($relation[1], 3)  ?>")
  		$relacionmodelo=new <?= substr($relation[1], 3)  ?>(); 
		<?php endforeach; ?>
 $nombre=$relacionmodelo->checkname($csvcolumna);
		return $nombre;
	}
}
