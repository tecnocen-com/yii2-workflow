<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table `{{%credit}}`.
 *
 * @property integer $id
 * @property string $credit
 */
class Credit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%credit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'workflow_id' => Yii::t('app', 'Workflow ID'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::class, ['id' => 'workflow_id']);
    }
}
