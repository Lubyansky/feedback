<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;

class Appeal extends Model
{
    private static $appeals = [
        '0' => [
            'id' => '0',
            'surname' => 'Валерьев',
            'name' => 'Валерий',
            'patronymic' => 'Валерьевич',
            'phoneNumber' => '79085026388',
            'email' => 'valerievvv@mail.ru',
            'text' => 'text',
            'file' => 'none',
            'date' => '30.06.2022',
            'time' => '14:10:25',
        ],
        '1' => [
            'id' => '1',
            'surname' => 'Касимов',
            'name' => 'Егор',
            'patronymic' => 'Дмитриевич',
            'phoneNumber' => '79085267388',
            'email' => 'abc@mail.ru',
            'text' => 'text',
            'file' => 'none',
            'date' => '30.06.2022',
            'time' => '14:10:25',
        ]
    ];

    public function getAppeals(){
        return self::$appeals;
    }

    public function findAppealById($id){
        foreach (self::$appeals as $appeal) {
            if (strcasecmp($appeal['id'], $id) === 0) {
                return $appeal;
            }
        }
        return null;
    }

}