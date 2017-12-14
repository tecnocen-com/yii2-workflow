<?php

namespace app\models;

use Yii;
use tecnocen\workflow\models\Workflow;

/**
 * This is the model class for table `{{%credit}}`.
 *
 * @property integer $id
 * @property string $credit
 */
class Credit extends \tecnocen\workflow\models\Process
{
    /**
     * @var string full class name of the model to be used for the relation
     * `getWorkflow()`.
     */
    protected $workflowClass = Workflow::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%credit}}';
    }

    protected function workLogClass()
    {
        return CreditWorklog::class;
    }

    public function getWorkflowId()
    {
        return $this->workflow_id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_id'], 'required'],
            [
                ['workflow_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Workflow::class,
                'targetAttribute' => ['workflow_id' => 'id'],
            ],
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
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::class, ['id' => 'workflow_id']);
    }
}
