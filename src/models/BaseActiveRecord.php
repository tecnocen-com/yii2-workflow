<?php

namespace tecnocen\workflow\models;

use yii\behaviors\AttributeTypecastBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
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
     * @return string namespace of the model
     */
    public function getNamespace()
    {
        $class = static::class;
        return substr($class, 0, strrpos($class, '\\'));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                'attributeTypes' => $this->attributeTypecast(),
                'typecastAfterFind' => true,
            ],
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
     * @return string[] pairs of 'attribute' => 'cast_type' to be passed to
     * `AttributeTypeCastBehavior`
     */
    protected function attributeTypecast()
    {
        return ['created_by' => 'integer'];
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
