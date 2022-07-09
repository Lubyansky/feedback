<?php

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\modules\models\AppealForm;
use app\modules\models\Appeal;
use app\modules\models\AppealSearch;

class AppealsController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionForm() {

        $model = new AppealForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            $appeal = new Appeal();
            $appeal->setAppeal($model);

            if($appeal->save()){
                $model->saveFile($appeal->id);
                $model->contact('admin@mail.su', $appeal->id);
                Yii::$app->session->setFlash('contactFormSubmitted');
            }
            else {
                Yii::$app->session->setFlash('contactFormNotSubmitted');
            }

            return $this->refresh();
        }
        return $this->render('appeal-form', [
            'model' => $model,
        ]);
    }

    public function actionAppeals(){

        $searchModel = new AppealSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($searchModel->load(Yii::$app->request->post())) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('appeals', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppeal($id){

        $appeal = (new Appeal())->getAppeal($id);

        return $this->render('appeal', [
            'appeal' => $appeal
        ]);
    }

    public function actionDownload($id) {

        $file = (new Appeal())->getFile($id);

        return \Yii::$app->response->sendFile($file);
    }

}
