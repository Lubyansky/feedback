<?php

namespace app\modules\feedback\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\feedback\models\default\AppealForm;
use app\modules\feedback\models\appeals\Appeal;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post'],
                ]
            ],
        ];
    }

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
    
    public function actionIndex()
    {
        $model = new AppealForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            $appeal = new Appeal();
            $appeal->setAppeal($model);

            if($appeal->save()){
                $model->saveFile($appeal->id);
                $model->contact($appeal->id);
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
}