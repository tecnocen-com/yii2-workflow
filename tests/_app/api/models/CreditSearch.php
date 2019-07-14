<?php

namespace app\api\models;

use tecnocen\roa\ResourceSearch;
use yii\data\ActiveDataProvider;

class CreditSearch extends Credit implements ResourceSearch
{
    /**
     * @inhertidoc
     */
    protected $autogenerateInitialWorklog = false;

    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
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
        ]);
    }
}
