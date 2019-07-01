<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "project_role".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\Participant[] $participants
 */
class ProjectRole extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'participants'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_role';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(\app\models\Participant::className(), ['project_role_id' => 'id', 'project_role_name' => 'name']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\ProjectRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ProjectRoleQuery(get_called_class());
    }
}
