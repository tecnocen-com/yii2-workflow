<?php

namespace tecnocen\workflow\models;

/**
 * Model class for table `{{%workflow}}`
 *
 * @property integer $id
 * @property string $name
 *
 * @property Stage[] $stages
 */
class Workflow extends \tecnocen\rmdb\models\PersistentEntity
{
    /**
     * @var string full class name of the model to be used for the relation
     * `getStages()`.
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow}}';
    }

    /**
     * @inheritdoc
     */
    protected function attributeTypecast()
    {
        return parent::attributeTypecast() + ['id' => 'integer'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 6],
            [['name'], 'unique'],
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
    public function getStages()
    {
        return $this->hasMany($this->stageClass, ['workflow_id' => 'id'])
            ->inverseOf('workflow');
    }

    public function getDetailStages()
    {
        $query = $this->getStages();
        $query->multiple = false;

        return $query->select([
            'totalStages' => 'count(distinct id)',
        ])->asArray()
        ->groupBy('workflow_id');
    }

    public function getTotalStages()
    {
        return (int)$this->detailStages['totalStages'];
    }
}
