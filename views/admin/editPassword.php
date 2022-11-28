<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Изменить пароль';
?>

<div class="admin-settings">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'edit-settings-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rePassword')->passwordInput() ?>

        <div class="form-group">
            <?= Html::a('Назад', ['settings'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'settings-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>