<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Обращение';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin-top:20px;">

        <div><?= Html::encode($appeal['date']) ?> <?= Html::encode($appeal['time']) ?></div>

        <h2><?= Html::encode($appeal['surname']) ?> <?= Html::encode($appeal['name']) ?> <?= Html::encode($appeal['patronymic']) ?></h2>

        <a href="tel:+<?= Html::encode($appeal['phoneNumber']) ?>">+<?= Html::encode($appeal['phoneNumber']) ?></a>

        <a href="mailto:<?= Html::encode($appeal['email']) ?>"><?= Html::encode($appeal['email']) ?></a>

        <p><?= Html::encode($appeal['text']) ?></p>
        
        <?php if(array_key_exists('file', $appeal) && $appeal['file']): ?>
            <a href="<?=Url::to(['appeals/download', 'id' => $appeal['id']])?>"><?= Html::encode($appeal['file']) ?></a>
        <?php endif; ?>
    </div>

    <a href="<?=Url::to(['appeals/appeals'])?>">Назад</a>

</div>
