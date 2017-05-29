<?php

namespace tecnocen\workflow\models;
/**
 * Model class for table `{{%tecnocen_workflow_stage}}`
 *
 * @property integer $id
 * @property integer $workflow_id
 * @property string $name
 * @property boolean $initial
 *
 * @property Workflow $workflow
 * @property Transition[] $transitions
 */
class Stage extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tecnocen_workflow_stage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_id', 'name'], 'required'],
            [['initial'], 'default', 'value' => false],
            [['initial'], 'boolean'],
            [['workflow_id'], 'integer'],
            [
                ['workflow_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Workflow::class,
                'targetAttribute' => ['workflow_id' => 'id'],
            ],
            [['name'], 'string', 'min' => 8],
            [['name'], 'unique', 'targetAttribute' => ['workflow_id', 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'id' => 'ID',
            'name' => 'Stage name',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(
            $this->getNamespace() . '\\Workflow',
            ['id' => 'workflow_id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitions()
    {
        return $this->hasMany(
            $this->getNamespace() . '\\Transition',
            ['source_stage_id' => 'id']
        )->inverseOf('source');
    }

    /**
     * @return \yii\db\ActiveQuery sibling stages for the same workflow
     */
    public function getSiblings()
    {
        return $this->hasMany(static::class, ['workflow_id' => 'workflow_id'])
            ->alias('siblings');
    }
}
