<?php

namespace app\modules\feedback\models\default;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\modules\feedback\models\appeals\Appeal;
use app\modules\feedback\models\user\User;

class AppealForm extends Model
{
    public $surname;
    public $name;
    public $patronymic;
    public $phoneNumber;
    public $email;
    public $text;
    public $file;
    public $verifyCode;

    public function rules() {
        return [
            [['surname', 'name', 'patronymic', 'phoneNumber', 'email', 'text', 'verifyCode'], 'required', 'message' => 'Необходимо заполнить поле.'],
            [['surname', 'name', 'patronymic', 'phoneNumber', 'email', 'text', 'verifyCode'], 'trim'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 40, 'tooLong' => 'Максимальное количество доступных для ввода символов: {max}.'],
            ['text', 'string', 'max' => 65000, 'tooLong' => 'Максимальное количество доступных для ввода символов: {max}.'],
            ['email', 'email', 'message' => 'Введите корректный адрес.'],
            ['phoneNumber', 'match', 'pattern' => '[^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$]', 'message' => 'Введите корректный номер телефона.'],
            [
                ['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, pdf, zip', 'maxSize' => 1024*1024, 'maxFiles' => 1, 
                'wrongExtension'=>'Разрешенные типы файлов: {extensions}.', 'tooBig' => 'Размер файла не должен превышать 1 Мб.'
            ],
            ['verifyCode', 'captcha', 'captchaAction' => '/feedback/default/captcha']
        ];
    }

    public function attributeLabels() {
        return [
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'text' => 'Текст',
            'file' => 'Приложение',
            'phoneNumber' => 'Номер телефона',
            'email' => 'Адрес электронной почты',
            'verifyCode' => 'Проверочный код'
        ];
    }

    public function saveFile($id){
        if($_FILES["AppealForm"]["name"]["file"]) {
            $this->file = UploadedFile::getInstance($this, 'file');
            $path = Yii::getAlias(Yii::$app->getModule('feedback')->params['uploadedFilesPath'] . $id . "/"); 
            FileHelper::createDirectory($path);
            $this->file->saveAs($path . $this->file->baseName . '.' . $this->file->extension);

            return true;
        }

        return false;
    }

    public function contact($id){
        $fullName = $this->surname . " " . $this->name . " " . $this->patronymic;
        $message = Yii::$app->mailer->compose('@app/modules/feedback/mail/appeal', ['appeal' => $this, 'id' => $id]);

        $users = User::getAllUser();
        $recipients = [];

        foreach ($users as $user) {
            array_push($recipients, $user->email);
        }
        
        $message->setTo($recipients)
            ->setFrom([$this->email => $fullName])
            ->setSubject("Обращение № " . $id . " от " . $fullName)
            ->setTextBody($this->text);
        if($this->file){
            $message->attach(Appeal::getFile($id));
        }
        $message->send();
    }
}