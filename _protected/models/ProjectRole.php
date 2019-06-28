<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_role".
 *
 * @property int $id
 * @property string $name
 *
 * @property Participant[] $participants
 */
class ProjectRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
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
        return $this->hasMany(Participant::className(), ['project_role_id' => 'id', 'project_role_name' => 'name']);
    }
}
