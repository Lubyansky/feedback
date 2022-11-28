<?php

namespace app\modules\feedback\models\user;

use \yii\db\ActiveRecord;
use \yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    // В таблице используются поля id, username, password[в виде хэша], email, authKey[по факту не используется], accessToken[по факту не используется]
    public static function tableName() {
        return 'admins';
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function getAllUser()
    {
        return static::find()->all();
    }

}
