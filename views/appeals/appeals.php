<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Appeals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php  foreach ($appeals as $appeal) :?>
        <a style="margin-top:20px;" href="<?=Url::to(['appeals/appeal', 'id' => $appeal['id']])?>">
            <?= Html::encode($appeal['surname']) ?> <?= Html::encode($appeal['name']) ?> <?= Html::encode($appeal['patronymic']) ?>
            <a href="tel:+<?= Html::encode($appeal['phoneNumber']) ?>">+<?= Html::encode($appeal['phoneNumber']) ?></a>
            <br><?= Html::encode($appeal['date']) ?> <?= Html::encode($appeal['time']) ?>
        </a>
    <?php endforeach; ?>

</div>
