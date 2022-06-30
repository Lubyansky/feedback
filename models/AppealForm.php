<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use app\modules\models\Appeal;

$model = new Appeal;

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

     /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['surname', 'name', 'patronymic', 'phoneNumber', 'email', 'text'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['phoneNumber', 'number']
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
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

            array_push($model->setAppeals([
                'id' => '1',
                'surname' => $this->surname,
                'name' => $this->name,
                'patronymic' => $this->patronymic,
                'phoneNumber' => $this->phoneNumber,
                'email' => $this->email,
                'text' => $this->text,
                'file' => $this->file
            ]));
            return true;
        }
        return false;
    }

}