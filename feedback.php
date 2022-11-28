<?php

namespace app\modules\feedback;

class feedback extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\feedback\controllers';

    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/config.php'));
    }
}
