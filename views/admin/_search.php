<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;

?>

<form method="get" action="<?= Url::to([Url::base()]); ?>" class="pull-right" id="search-form">

    <div class="input-group">

        <input type="text" name="query" class="form-control" placeholder="Поиск">

        <div class="form-group" style="padding-left:10px;">

            <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>

            <?= Html::resetButton('Сбросить', ['class' => 'btn btn-primary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
                
        </div>

    </div>

 </form>

<?php if($searchModel->validate()): ?>

    </br><h4 style="margin-bottom:20px;"> Результаты поиска по запросу: <?= Html::encode($searchModel->search) ?></h4>

<?php endif; ?>