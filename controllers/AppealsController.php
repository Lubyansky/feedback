<?php

namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\helpers\FileHelper;
use app\modules\models\AppealForm;
use app\modules\models\Appeal;

class AppealsController extends Controller
{
    public function actions()
    {
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

    public function actionForm()
    {
        $model = new AppealForm();

        if ($model->load(Yii::$app->request->post())) {
            $appeal = new Appeal();
            $appeal->surname = $model->surname;
            $appeal->name = $model->name;
            $appeal->patronymic = $model->patronymic;
            $appeal->phoneNumber = $model->phoneNumber;
            $appeal->email = $model->email;
            $appeal->text = $model->text;
            $appeal->date = date('Y-m-d');
            $appeal->time = date('H:i:s');
            if($appeal->save()){
                if($_FILES["AppealForm"]["name"]["file"]){
                    $model->file = UploadedFile::getInstance($model, 'file');
                    /*if($model->file->size > 1*8){
                        throw new \Exception('File size over 1Mb');
                    }*/
                    $path = Yii::getAlias('@app/modules/uploads/' . $appeal->id . "/"); 
                    FileHelper::createDirectory($path);
                    $model->file->saveAs($path . $model->file->baseName . '.' . $model->file->extension);
                }
                //$model->contact(Yii::$app->params['adminEmail']);
                Yii::$app->session->setFlash('contactFormSubmitted');
            }
            else{
                Yii::$app->session->setFlash('contactFormNotSubmitted');
            }
            return $this->refresh();
        }
        return $this->render('appeal-form', [
            'model' => $model,
        ]);
    }

    public function actionAppeals()
    {
        $appeals = Appeal::find();
        $pages = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $appeals->count()
        ]);
        $appeals = $appeals->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('appeals', [
            'appeals' => $appeals,
            'pages' => $pages
        ]);
    }

    public function actionAppeal($id)
    {
        $appeal = Appeal::find()->asArray()->where('id=:id', [':id' => $id])->one();
        $path = Yii::getAlias('@app/modules/uploads/' . $id . '/');
        $appeal['file'] = '';
        if(file_exists($path)){
            $file = FileHelper::findFiles($path);
            $appeal['file'] = basename($file[0]);
        }
        return $this->render('appeal', [
            'appeal' => $appeal
        ]);
    }

    public function actionDownload($id) {
        $path = Yii::getAlias('@app/modules/uploads/' . $id . '/');
     
        if (file_exists($path)) {
            $file = FileHelper::findFiles($path);
            return \Yii::$app->response->sendFile($file[0]);
        } 
        throw new \Exception('File not found');
     }
}
