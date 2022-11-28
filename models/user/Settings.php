<?php

namespace app\modules\feedback\models\user;

use Yii;
use yii\base\Model;
use app\modules\feedback\models\user\User;

class Settings extends Model
{
    public $username;
    public $email;
    public $password;
    public $rePassword;
    private $userID;

    const SCENARIO_VIEW_USER = 'viewUser';
    const SCENARIO_EDIT_USER = 'editUser';
    const SCENARIO_EDIT_PASSWORD = 'editPassword';

    public function scenarios()
    {
        return [
            self::SCENARIO_VIEW_USER => ['username', 'email'],
            self::SCENARIO_EDIT_USER => ['username', 'email'],
            self::SCENARIO_EDIT_PASSWORD => ['password', 'rePassword'],
        ];
    }

    public function rules() {
        return [
            //User editing
            [
                ['username', 'email'],
                'required',
                'message' => 'Заполните поле',
                'on' => self::SCENARIO_EDIT_USER],
            [
                'username',
                'match',
                'pattern' => '/^[A-Z0-9]+$/', 
                'message' => 'Разрешены только прописные символы английского алфавита и цифры.',
                'on' => self::SCENARIO_EDIT_USER
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'targetAttribute' => ['username'],
                'filter' => function($query) {
            
                    $query->andWhere(['not like', 'id', $this->userID]);
            
                },
                'message' => 'Пользователь с таким именем уже зарегистрирован',
                'on' => self::SCENARIO_EDIT_USER
            ],
            [
                'email',
                'email',
                'message' => 'Введите корректный адрес.',
                'on' => self::SCENARIO_EDIT_USER
            ],
            [
                ['username', 'email'], 
                'string', 
                'max' => 255, 
                'tooLong' => 'Максимальное количество доступных для ввода символов: {max}.'
            ],

            //Editing a password
            [
                ['password', 'rePassword'],
                'required',
                'message' => 'Заполните поле',
                'on' => self::SCENARIO_EDIT_PASSWORD],
            [
                'password',
                'string',
                'min' => 10,
                'max' => 50, 
                'tooShort' => 'Минимальная длина пароля {min} символа(ов).',
                'tooLong' => 'Максимальная длина пароля {max} символа(ов).',
                'on' => self::SCENARIO_EDIT_PASSWORD
            ],
            [
                'password',
                'match',
                'pattern' => '/(?=.*_)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/',
                'message' => 'Пароль обязательно должен включать в себя строчные и прописные буквы латинского алфавита, цифры и символ подчеркивания.',
                'on' => self::SCENARIO_EDIT_PASSWORD
            ],
            [
                'password',
                'match',
                'pattern' => '/^[a-zA-Z0-9_]+$/', 
                'message' => 'Разрешены только строчные и прописные символы английского алфавита, цифры и символ подчеркивания.',
                'on' => self::SCENARIO_EDIT_PASSWORD
            ],
            [
                'rePassword',
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли должны совпадать.',
                'on' => self::SCENARIO_EDIT_PASSWORD
            ]
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Новый пароль',
            'rePassword' => 'Повторите новый пароль',
            'email' => 'Email'
        ];
    }

    public function saveSettings($id){
        $User = User::findIdentity($id);
        $this->userID = $id;

        if($this->validate()){
            $User->username = $this->username ? $this->username : $User->username;
            $User->email = $this->email ? $this->email : $User->email;
            $User->password = $this->password ? Yii::$app->getSecurity()->generatePasswordHash($this->password) : $User->password;
            $User->save();
            return true;
        }
        return false;
    }

}