<?php

namespace app\modules\controllers;

use yii\web\Controller;
use app\modules\models\Appeal;

class AppealsController extends Controller
{
    public function actionAppeals()
    {
        $model = new Appeal;

        return $this->render('appeals', [
            'appeals' => $model->getAppeals()
        ]);
    }
    public function actionAppeal($id)
    {
        $model = new Appeal;

        return $this->render('appeal', [
            'appeal' => $model->findAppealById($id)
        ]);
    }
}
