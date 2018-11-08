<?php

namespace tecnocen\workflow\roa\models;

use tecnocen\roa\ResourceSearch;
use yii\data\ActiveDataProvider;

/**
 * Contract to filter and sort collections of `Workflow` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class WorkflowSearch extends Workflow implements ResourceSearch
{
    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inhertidoc
     */
    public function search(
        array $params,
        ?string $formName = ''
    ): ?ActiveDataProvider {
        $this->load($params, $formName);
        if (!$this->validate()) {
            return null;
        }

        $class = get_parent_class();
        return new ActiveDataProvider([
            'query' => $class::find()->andFilterWhere([
                    'created_by' => $this->created_by,
                ])
                ->andFilterWhere(['like', 'name', $this->name]),
        ]);
    }
}
