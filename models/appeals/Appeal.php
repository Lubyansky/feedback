<?php

namespace app\modules\feedback\models\appeals;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Html;

class Appeal extends ActiveRecord
{
    // В таблице используются поля id, surname, name, patronymic, phoneNumber, email, text, date, time
    public static function tableName() {
        return 'appeals';
    }

    public $file;

    public function setAppeal($model) {
        $this->surname = Html::encode($model->surname);
        $this->name = Html::encode($model->name);
        $this->patronymic = Html::encode($model->patronymic);
        $this->phoneNumber = preg_replace('#[^0-9]#u', '', Html::encode($model->phoneNumber));
        $this->email = Html::encode($model->email);
        $this->text = Html::encode($model->text);
        $this->date = date('Y-m-d');
        $this->time = date('H:i:s');
    }

    public function getAppeal($id){
        $appeal = Appeal::find()->where('id=:id', [':id' => $id])->one();
        if($appeal == NULL){
            throw new \Exception('Appeal not found');
        }
        $path = Yii::getAlias(Yii::$app->getModule('feedback')->params['uploadedFilesPath'] . $id . '/');

        if(file_exists($path)){
            $file = FileHelper::findFiles($path);
            $appeal->file = basename($file[0]);
        }
        $appeal->date = Yii::$app->formatter->asDate($appeal->date, 'dd.MM.yyyy');

        return $appeal;
    }

    public static function getFile($id){
        $path = Yii::getAlias(Yii::$app->getModule('feedback')->params['uploadedFilesPath'] . $id . '/');
     
        if (file_exists($path)) {
            $file = FileHelper::findFiles($path);

            return $file[0];
        } 
        throw new \Exception('File not found');
    }

    public function getFullName() {
        return $this->surname . ' ' . $this->name . ' ' . $this->patronymic;
    }

}