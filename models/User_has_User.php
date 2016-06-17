<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "User_has_User".
 *
 * @property integer $User_id
 * @property integer $User_id1
 *
 * @property User $user
 * @property User $userId1
 */
class User_has_User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User_has_User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['User_id', 'User_id1'], 'required'],
            [['User_id', 'User_id1'], 'integer'],
            [['User_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['User_id' => 'id']],
            [['User_id1'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['User_id1' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'User_id' => 'User ID',
            'User_id1' => 'User Id1',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'User_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserList()
    {
        return ArrayHelper::map(User::find()->all(),'id','Nombre');    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId1()
    {
        return $this->hasOne(User::className(), ['id' => 'User_id1']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId1List()
    {
        return ArrayHelper::map(UserId1::find()->all(),'id','Nombre');    }
}
