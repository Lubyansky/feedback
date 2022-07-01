<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Обращения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php  foreach ($appeals as $appeal) :?>
        <div style="margin-top:20px;">
            <a href="<?=Url::to(['appeals/appeal', 'id' => $appeal['id']])?>">
                <?= Html::encode($appeal['surname']) ?> 
                <?= Html::encode($appeal['name']) ?> 
                <?= Html::encode($appeal['patronymic']) ?>
            </a>
            <a href="tel:+<?= Html::encode($appeal['phoneNumber']) ?>">+<?= Html::encode($appeal['phoneNumber']) ?></a>
            <span><?= Html::encode($appeal['date']) ?> <?= Html::encode($appeal['time']) ?></span>
        </div>
    <?php endforeach; ?>
    <div class="pagination">
        <?echo LinkPager::widget(['pagination' => $pages]) ?>
    </div>

</div>
