<?php

namespace app\modules\models;

use yii\db\ActiveRecord;

class Appeal extends ActiveRecord
{
    public static function tableName()
    {
        return 'appeals';
    }
}