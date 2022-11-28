<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = 'Обращение №'.$appeal->id;
$this->params['breadcrumbs'][] = $this->title;

?>

<div>

    <h1 style="margin-bottom:40px;"><?= Html::encode($this->title) ?></h1>

    <?php
        echo DetailView::widget([
            'model' => $appeal,
            'attributes' => [
                [
                    'attribute' => 'date',
                    'format' => 'text',
                    'label' => 'Дата отправления'
                ],
                [
                    'attribute' => 'time',
                    'format' => 'text',
                    'label' => 'Время отправления'
                ],
                [
                    'attribute' => 'surname',
                    'format' => 'text',
                    'label' => 'Фамилия'
                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                    'label' => 'Имя'
                ],
                [
                    'attribute' => 'patronymic',
                    'format' => 'text',
                    'label' => 'Отчество'
                ],
                [
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a('+' . $data->phoneNumber, 'tel:' . '+' . $data->phoneNumber);
                    },
                    'label' => 'Номер телефона'
                ],
                [
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::mailto($data->email, $data->email);
                    },
                    'label' => 'Email'
                ],
                [
                    'value' => $appeal->text,
                    'label' => 'Текст'
                ],
                [
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->file, Url::to(['admin/download', 'id' => $data->id]));
                    },
                    'visible' => !empty($appeal->file),
                    'label' => 'Приложенный файл'
                ]
            ]
        ]);
    ?>

    <?= Html::a('Назад', ['admin/appeals'], ['class' => 'btn btn-primary']) ?>

</div>
