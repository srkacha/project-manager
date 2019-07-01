<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property integer $status
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $account_activation_token
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \app\models\Participant[] $participants
 * @property \app\models\Project[] $projects
 * @property \app\models\Supervisor[] $supervisors
 */
class User extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'participants',
            'projects',
            'supervisors'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'email', 'password_hash', 'status', 'auth_key', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'surname', 'username', 'email', 'password_hash', 'password_reset_token', 'account_activation_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['account_activation_token'], 'unique'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
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
            'surname' => 'Surname',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'account_activation_token' => 'Account Activation Token',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(\app\models\Participant::className(), ['user_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(\app\models\Project::className(), ['manager_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupervisors()
    {
        return $this->hasMany(\app\models\Supervisor::className(), ['user_id' => 'id']);
    }
    

    /**
     * @inheritdoc
     * @return \app\models\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\UserQuery(get_called_class());
    }
}
