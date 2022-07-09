<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\modules\models\Appeal;

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

    public function rules()
    {
        return [
            [['surname', 'name', 'patronymic', 'phoneNumber', 'email', 'text', 'verifyCode'], 'required', 'message' => 'Заполните поле'],
            [['surname', 'name', 'patronymic', 'phoneNumber', 'email', 'text', 'verifyCode'], 'trim'],
            ['surname', 'string', 'max' => 40, 'tooLong' => 'Количество доступных для ввода символов: 40'],
            ['name', 'string', 'max' => 40, 'tooLong' => 'Количество доступных для ввода символов: 40'],
            ['patronymic', 'string', 'max' => 40, 'tooLong' => 'Количество доступных для ввода символов: 40'],
            ['text', 'string', 'max' => 65000, 'tooLong' => 'Количество доступных для ввода символов: 65000'],
            ['email', 'email', 'message' => 'Введите корректный адрес'],
            ['phoneNumber', 'match', 'pattern' => '[^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$]', 'message' => 'Введите корректный номер телефона'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, pdf, zip', 'maxSize' => 1024*1024, 'maxFiles' => 1, 'message' => 'Расширение doc, pdf, zip, размер до 1 Мб'],
            ['verifyCode', 'captcha', 'captchaAction' => '/feedback/appeals/captcha']
        ];
    }

    public function attributeLabels()
    {
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
        if($_FILES["AppealForm"]["name"]["file"]){
            $this->file = UploadedFile::getInstance($this, 'file');
            $path = Yii::getAlias('@app/modules/uploads/' . $id . "/"); 
            FileHelper::createDirectory($path);
            $this->file->saveAs($path . $this->file->baseName . '.' . $this->file->extension);

            return true;
        }
        return false;
    }

    public function contact($email, $id)
    {
        $fullName = $this->surname . " " . $this->name . " " . $this->patronymic;
        $message = Yii::$app->mailer->compose();
        $message->setTo($email)
            ->setFrom([$this->email => $fullName])
            ->setSubject("Обращение № " . $id + 1 . " от " . $fullName)
            ->setTextBody($this->text);
        if($this->file){
            $message->attach(Appeal::getFile($id));
        }
        $message->send();
    }
}