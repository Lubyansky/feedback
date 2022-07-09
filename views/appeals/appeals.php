<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Alert;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\SerialColumn;
use yii\grid\GridView;

$this->title = 'Обращения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php  Pjax::begin([]); ?>

    <form method="get" action="<?= Url::to(['appeals/appeals']); ?>" class="pull-right">
        <div class="input-group">

            <input type="text" name="query" class="form-control" placeholder="Поиск">

            <div class="form-group">

                <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>

                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-primary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
                
            </div>
        </div>
    </form>

    <?php if($searchModel->search): ?>
        <h2>Результаты поиска по запросу: <?= Html::encode($searchModel->search) ?></h2>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(['options' => ['data' => ['pjax' => true]],]); ?>
        <?= $form->field($searchModel, 'pageSize')->radioList(
                ['10' => '10', '20' => '20', '50' => '50', '100' => '100'],
                [
                    'item' => function($index, $label, $name, $checked, $value) {
                        $checked = $checked ? 'checked' : '';
                        return "
                            <label>
                                <input type='radio' {$checked} name='{$name}'value='{$value}'id='idName_{$value}'onChange='this.form.submit();'>
                                {$label}
                            </label>";
                    },
                    'value' => $searchModel->pageSize
                ]
            )->label('<br/>Количество обращений на странице:');
        ?>
    <?php ActiveForm::end(); ?>
    <? if($dataProvider->getTotalCount() > 0) {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => SerialColumn::className()],
                    [
                        'attribute' => 'surname',
                        'format' => 'text',
                        'label' => 'Фамилия',
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'text',
                        'label' => 'Имя',
                    ],
                    [
                        'attribute' => 'patronymic',
                        'format' => 'text',
                        'label' => 'Отчество',
                    ],
                    [
                        'attribute' => 'phoneNumber',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('+' . $data->phoneNumber, 'tel:' . '+' . $data->phoneNumber);
                        },
                        'label' => 'Номер телефона',
                    ],
                    [
                        'attribute' => 'date',
                        'format' => ['date', 'dd.MM.yyyy'],
                        'label' => 'Дата',
                    ],
                    [
                        'label' => 'Подробнее',
                        'format' => 'raw',
                        'value' => function($data){
                            return Html::a(
                                'Перейти',
                                [
                                    'appeals/appeal', 
                                    'id' => $data->id
                                ],
                                [
                                    'target' => '_blank',
                                    'rel' => 'noopener noreferrer'
                                ]

                            );
                        }
                    ],
                ],
            ]); 
        }
        else {

            echo Alert::widget([
                'body' => 'Ничего не найдено',
                'options' => [
                    'class' => 'alert alert-danger'
                ]
            ]);
        
        }
    ?>

    <?php Pjax::end(); ?>
    
</div>
