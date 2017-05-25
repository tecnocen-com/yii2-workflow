<?php

namespace tecnocen\workflow\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression as DbExpression;

/**
 * Base Model class for the models used on the workflow library
 *
 * @property string $created_at
 * @property integer $created_by
 *
 * @property ActiveRecord $creator
 */
class BaseActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => null,
                'value' => new DbExpression('now()'),
            ],
            'blame' => [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => null,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_at' => 'Created At Date',
            'created_by' => 'Created By User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(
            Yii::$app->user->identityClass,
            ['id' => 'created_by']
        );
    }
}
