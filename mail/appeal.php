<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;

$this->title = 'Обращение №'.$id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    
    <h1 style="margin-bottom:40px;"><?= Html::encode($this->title) ?></h1>

    <?php
        echo DetailView::widget([
            'model' => $appeal,
            'options' => ['class' => 'table table-striped table-bordered'],
            'attributes' => [
                [
                    'attribute' => 'surname',
                    'format' => 'raw',
                    'label' => 'Фамилия'
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'label' => 'Имя'
                ],
                [
                    'attribute' => 'patronymic',
                    'format' => 'raw',
                    'label' => 'Отчество'
                ],
                [
                    'format' => 'raw',
                    'value' => $appeal->phoneNumber,
                    'label' => 'Номер телефона'
                ],
                [
                    'format' => 'raw',
                    'value' => $appeal->email,
                    'label' => 'Email'
                ],
                [
                    'format' => 'raw',
                    'value' => $appeal->text,
                    'label' => 'Текст'
                ]
            ]
        ]);
    ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

