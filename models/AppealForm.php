<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;

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
            [['surname', 'name', 'patronymic', 'phoneNumber', 'email', 'text', 'verifyCode'], 'required'],
            ['email', 'email'],
            ['phoneNumber', 'number'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, pdf, zip', 'maxSize' => 1024*1024, 'maxFiles' => 1],
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

    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->surname + " " + $this->name])
                ->setSubject("Appeal")
                ->setTextBody($this->text)
                ->attach($this->file)
                ->send();

            return true;
        }
        return false;
    }
}