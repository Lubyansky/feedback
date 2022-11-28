<?php

$config = [
    'id' => 'feedback',
    'basePath' => dirname(__DIR__),
    'components' => [
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\feedback\models\user\User',
            'loginUrl' => ['feedback/admin/login'],
            'idParam' => 'feedback_admin_id',
            'identityCookie' => [
                'name' => '_identity-api',
                'httpOnly' => true
            ],
            'enableAutoLogin' => true
        ]
    ],
    'params' => [
        'uploadedFilesPath' => '@app/modules/feedback/uploads/'
    ],
    'modules' => [
    ]
];

return $config;
