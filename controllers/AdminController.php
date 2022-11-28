<?php

namespace app\modules\feedback\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\feedback\models\user\LoginForm;
use app\modules\feedback\models\user\Settings;
use app\modules\feedback\models\appeals\Appeal;
use app\modules\feedback\models\appeals\AppealSearch;

class AdminController extends Controller {

    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => Yii::$app->getModule('feedback')->get('admin'),
                'only' => ['index', 'appeal', 'download', 'logout', 'settings'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function () {
                            return Yii::$app->response->redirect(['feedback/admin/login']);
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post'],
                    'appeal' => ['get'],
                    'download' => ['get'],
                    'login' => ['get', 'post'],
                    'logout' => ['post'],
                    'settings' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex(){

        $searchModel = new AppealSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $searchModel->pageSize);

        //for dynamic pagination
        if($searchModel->load(Yii::$app->request->post())){
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('appeals', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider
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

    public function actionLogin() {
        
        if (!Yii::$app->getModule('feedback')->get('admin')->isGuest) {
            return Yii::$app->response->redirect(['feedback/admin/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return Yii::$app->response->redirect(['feedback/admin/index']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->getModule('feedback')->get('admin')->logout();

        return $this->goHome();
    }

    public function actionSettings() { 

        $model = new Settings();
        $user = Yii::$app->getModule('feedback')->get('admin')->identity;

        return $this->render('settings', [
            'model' => $model,
            'user' => $user
        ]);
    }

    public function actionEditUser() { 

        $model = new Settings();
        $model->scenario = Settings::SCENARIO_EDIT_USER;
        $user = Yii::$app->getModule('feedback')->get('admin')->identity;

        if ($model->load(Yii::$app->request->post()) && $model->saveSettings($user->id)) {
            return Yii::$app->response->redirect(['feedback/admin/settings']);
        }
        
        return $this->render('editUser', [
            'model' => $model,
            'user' => $user
        ]);
    }

    public function actionEditPassword() { 

        $model = new Settings();
        $model->scenario = Settings::SCENARIO_EDIT_PASSWORD;
        $user = Yii::$app->getModule('feedback')->get('admin')->identity;

        if ($model->load(Yii::$app->request->post()) && $model->saveSettings($user->id)) {
            return Yii::$app->response->redirect(['feedback/admin/settings']);
        }
        
        return $this->render('editPassword', [
            'model' => $model,
            'user' => $user
        ]);
    }
}