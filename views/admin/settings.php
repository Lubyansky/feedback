<?php

use yii\bootstrap5\Html;
use yii\widgets\Pjax;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-settings">
    <h1><?= Html::encode($this->title) ?></h1>

    <? Pjax::begin(['timeout' => 5000 ]); ?>

    <h4 style="margin-top: 40px; margin-bottom:20px;">Пользователь: <?= Html::encode($user->username) ?></h4>
    <h4 style="margin-bottom:20px;">Email: <?= Html::encode($user->email) ?></h4>

    <p>
        <div>
            <?= Html::a('Редактировать', ['edit-user'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Изменить пароль', ['edit-password'], ['class' => 'btn btn-primary']) ?>
        </div>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-primary', 'style' => 'margin-top: 20px;']) ?>
    </p>


    <? Pjax::end(); ?>

</div>