<?php

namespace tecnocen\workflow\models;

/**
 * Model class for table `{{%tecnocen_workflow}}`
 *
 * @property integer $source_stage_id
 * @property integer $target_stage_id
 * @property string $name
 *
 * @property Stage[] $stages
 */
class Workflow extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tecnocen_workflow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 8],
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
        return $this->hasMany(Stage::class, ['workflow_id' => 'id'])
            ->inverseOf('workflow');
    }
}
