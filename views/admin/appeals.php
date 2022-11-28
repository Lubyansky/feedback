<?php

use yii\bootstrap5\Alert;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;
use yii\grid\SerialColumn;
use yii\grid\GridView;
use yii\bootstrap5\LinkPager;

$this->title = 'Обращения';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>

    <h1 style="margin-bottom:40px;"><?= Html::encode($this->title) ?></h1>

    <? Pjax::begin(['timeout' => 5000, 'enableReplaceState' => true, 'enablePushState' => false]); ?>

    <? echo $this->render('_search', ['searchModel' => $searchModel]); ?>

    <? echo $this->render('_pageSizer', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]); ?>

    <div> 

        <? 
            if($dataProvider->getTotalCount() > 0) {

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'class' => LinkPager::class,
                        'firstPageLabel' => '«',
                        'lastPageLabel' => '»',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',

                        'maxButtonCount' => 5,
                    ],
                    'columns' => [
                        [
                            'class' => SerialColumn::className()
                        ],
                        [
                            'attribute' => 'fullName',
                            'format' => 'raw',
                            'label' => 'ФИО',
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
                            'contentOptions' => function ($model) {
                                return [
                                    'title' => date("d.m.Y", strtotime($model->date))." ".date("H:i:s", strtotime($model->time))
                                ];
                            }
                        ],
                        [
                            'label' => 'Подробнее',
                            'format' => 'raw',
                            'value' => function($data){
                                return Html::a(
                                    'Перейти',
                                    [
                                        'admin/appeal', 
                                        'id' => $data->id
                                    ],
                                    [
                                        'target' => '_blank',
                                        'rel' => 'noopener noreferrer'
                                    ]

                                );
                            }
                        ],
                    ]
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
    </div>

    <? Pjax::end(); ?>
    
</div>