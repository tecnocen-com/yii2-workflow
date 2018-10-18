<?php

namespace tecnocen\workflow\roa\resources;

use Yii;
use yii\web\NotFoundHttpException;
use tecnocen\workflow\roa\models\Stage;
use tecnocen\workflow\roa\models\StageSearch;

/**
 * Resource to
 */
class StageResource extends \tecnocen\roa\controllers\Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Stage::class;

    /**
     * @inheritdoc
     */
    public $searchClass = StageSearch::class;

    /**
     * @inheritdoc
     */
    public $filterParams = ['workflow_id'];
}
