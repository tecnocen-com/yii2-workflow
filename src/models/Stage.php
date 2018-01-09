<?php

namespace tecnocen\workflow\models;
/**
 * Model class for table `{{%workflow_stage}}`
 *
 * @property integer $id
 * @property integer $workflow_id
 * @property string $name
 * @property integer $position_x
 * @property integer $position_y
 * @property boolean $initial
 *
 * @property Workflow $workflow
 * @property Transition[] $transitions
 */
class Stage extends \tecnocen\rmdb\models\PersistentEntity
{
    /**
     * @var string full class name of the model to be used for the relation
     * `getWorkflow()`.
     */
    protected $workflowClass = Workflow::class;

    /**
     * @var string full class name of the model to be used for the relation
     * `getTransitions()`.
     */
    protected $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_stage}}';
    }

    /**
     * @inheritdoc
     */
    protected function attributeTypecast()
    {
        return parent::attributeTypecast() + [
            'id' => 'integer',
            'workflow_id' => 'integer',
            'initial' => 'boolean',
        ];
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
            [
                ['workflow_id', 'position_x', 'position_y'],
                'integer',
                'min' => 0,
            ],
            [
                ['workflow_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Workflow::class,
                'targetAttribute' => ['workflow_id' => 'id'],
            ],
            [['name'], 'string', 'min' => 6],
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
            'workflow_id' => 'Workflow ID',
            'position_x' => 'Position X',
            'position_y' => 'Position Y',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(
            $this->workflowClass,
            ['id' => 'workflow_id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransitions()
    {
        return $this->hasMany(
            $this->transitionClass,
            ['source_stage_id' => 'id']
        )->inverseOf('sourceStage');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailTransitions()
    {
        $query = $this->getTransitions();
        $query->multiple = false;

        return $query->select([
            'source_stage_id',
            'totalTransitions' => 'count(distinct target_stage_id)',
        ])->asArray()
        ->groupBy('source_stage_id');
    }

    /**
     * @return int
     */
    public function getTotalTransitions()
    {
        return (int)$this->detailTransitions['totalTransitions'];
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
