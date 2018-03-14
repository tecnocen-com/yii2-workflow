<?php

namespace tecnocen\workflow\models;

use tecnocen\rmdb\models\Pivot;

/**
 * @property int $process_id
 * @property int $user_id
 *
 * @property Process $process
 */
abstract class Assignment extends Pivot
{
    /**
     * @return string class name for the process this worklog is attached to.
     */
    protected abstract function processClass();

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'user_id'], 'required'],
            [['process_id', 'user_id'], 'integer'],
            [
                ['process_id'],
                'exist',
                'targetAttribute' => ['process_id' => 'id'],
                'targetClass' => $this->processClass(),
            ],
            [
                ['user_id'],
                'exist',
                'targetAttribute' => ['user_id' => 'id'],
                'targetClass' => Yii::$app->user->identityClass,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'process_id' => 'Process ID',
            'user_id' => 'User ID',
        ], parent::attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!is_subclass_of($this->processClass(), Process::class)) {
            throw new InvalidConfigException(
                static::class . '::processClass() must extend '
                    . Process::class
            );
        }
        parent::init();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne($this->processClass(), ['id' => 'process_id']);
    }
}
