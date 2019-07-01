<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "migration".
 *
 * @property string $version
 * @property integer $apply_time
 */
class Migration extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            ''
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version'], 'required'],
            [['apply_time'], 'integer'],
            [['version'], 'string', 'max' => 180]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'migration';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'version' => 'Version',
            'apply_time' => 'Apply Time',
        ];
    }


    /**
     * @inheritdoc
     * @return \app\models\MigrationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\MigrationQuery(get_called_class());
    }
}
