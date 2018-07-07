<?php

namespace app\api\resources;

use Yii;
use yii\web\NotFoundHttpException;
use app\api\models\CreditAssignment;

/**
 * CRUD resource for `Credit Assignment` records
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class CreditAssignmentResource extends \tecnocen\roa\controllers\OAuth2Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = CreditAssignment::class;

    public $filterParams = ['process_id'];
}
