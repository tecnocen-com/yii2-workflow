<?php

namespace tecnocen\workflow\models;
/**
 * Model class for table `{{%tecnocen_workflow_stage}}`
 *
 * @property integer $id
 * @property integer $workflow_id
 * @property string $name
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
            'name' => 'Workflow name',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::class, ['id' => 'workflow_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitions()
    {
        return $this->hasMany(Transition::class, ['source_stage_id' => 'id'])
            ->inverseOf('source');
    }
}
