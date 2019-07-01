<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property integer $user_id
 * @property integer $created_at
 *
 * @property \app\models\AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'itemName'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(\app\models\AuthItem::className(), ['name' => 'item_name']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\AuthAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\AuthAssignmentQuery(get_called_class());
    }
}
