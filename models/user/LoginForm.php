<?php

namespace app\modules\feedback\models\user;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules() {
        return [
            [['username', 'password'], 'required', 'message' => 'Необходимо заполнить поле.'],
            [['username', 'password'], 'string', 'max' => 255, 'tooLong' => 'Максимальное количество доступных для ввода символов: {max}.'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if (!$user || !Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {
                $this->addError('password', 'Неправильное имя пользователя или пароль');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->getModule('feedback')->get('admin')->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

