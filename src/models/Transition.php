<?php

namespace tecnocen\workflow\models;

use Yii;

/**
 * Model class for table `{{%workflow_transition}}`
 *
 * @property integer $source_stage_id
 * @property integer $target_stage_id
 * @property string $name
 *
 * @property Stage $sourceStage
 * @property Stage $targetStage
 * @property TransitionPermission[] $permissions
 */
class Transition extends \tecnocen\rmdb\models\Entity
{
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';

    /**
     * @var string full class name of the model to be used for the relations
     * `getSourceStage()` and `getTargetStage()`.
     */
    protected $stageClass = Stage::class;

    /**
     * @var string full class name of the model to be used for the relation
     * `getPermissions()`.
     */
    protected $permissionClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow_transition}}';
    }

    /**
     * @inheritdoc
     */
    protected function attributeTypecast()
    {
        return parent::attributeTypecast() + [
            'source_stage_id' => 'integer',
            'target_stage_id' => 'integer',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['!source_stage_id', '!target_stage_id'],
                'safe',
                'on' => [self::SCENARIO_UPDATE],
            ],
            [['name'], 'string', 'min' => 6],
            [['source_stage_id', 'target_stage_id', 'name'], 'required'],
            [
                ['source_stage_id', 'target_stage_id'],
                'integer',
                'on' => [self::SCENARIO_CREATE],
            ],
            [
                ['source_stage_id'],
                'exist',
                'targetClass' => Stage::class,
                'targetAttribute' => ['source_stage_id' => 'id'],
                'skipOnError' => true,
                'on' => [self::SCENARIO_CREATE],
            ],
            [
                ['target_stage_id'],
                'exist',
                'targetClass' => Stage::class,
                'targetAttribute' => ['target_stage_id' => 'id'],
                'skipOnError' => true,
                'on' => [self::SCENARIO_CREATE],
            ],
            [
                ['target_stage_id'],
                'exist',
                'targetAttribute' => [
                    'target_stage_id' => 'id',
                ],
                'targetClass' => Stage::class,
                'skipOnError' => true,
                'when' => function () {
                    return !$this->hasErrors('source_stage_id');
                },
                'filter' => function ($query) {
                    $query->innerJoinWith(['siblings'])->andWhere([
                        'siblings.id' => $this->source_stage_id
                    ]);
                },
                'on' => [self::SCENARIO_CREATE],
                'message' => 'The stages are not associated to the same workflow.',
            ],

            [
                ['target_stage_id'],
                'unique',
                'targetAttribute' => ['source_stage_id', 'target_stage_id'],
                'on' => [self::SCENARIO_CREATE],
                'message' => 'Target already in use for the source stage.'
            ],
            [
                ['name'],
                'unique',
                'targetAttribute' => ['source_stage_id', 'name'],
                'message' => 'Name already used for the source stage.'
            ],
        ];
    }

    /**
     * Whether the user can execute the transition.
     *
     * @param int $userId
     * @param Process $process
     * @return boolean
     */
    public function userCan($userId, Process  $process)
    {
        if (!$this->getPermissions()->exists()) {
            return true;
        }
        $authManager = Yii::$app->authManager;

        foreach ($this->permissions as $permission) {
            if (!$authManager->checkAccess($userId, $permission->permission, [
                'transition' => $this,
                'process' => $process
            ])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'source_stage_id' => 'Source Stage ID',
            'target_stage_id' => 'Target Stage ID',
            'name' => 'Transition Name',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceStage()
    {
        return $this->hasOne($this->stageClass, ['id' => 'source_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetStage()
    {
        return $this->hasOne($this->stageClass, ['id' => 'target_stage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(
            $this->permissionClass,
            [
                'source_stage_id' => 'source_stage_id',
                'target_stage_id' => 'target_stage_id',
            ]
        )->inverseOf('transition');
    }
}
