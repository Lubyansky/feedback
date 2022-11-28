<?php

use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

    <?= $form->field($searchModel, 'pageSize')->radioList(
        $searchModel->itemsPerPage(),
        [
            'item' => function($index, $label, $name, $checked, $value) {
                $checked = $checked ? 'checked' : '';
                return "
                    <label>
                        <input type='radio' {$checked} name='{$name}'value='{$value}'id='idName_{$value}'onChange='this.form.submit();'>
                        {$label}
                    </label>";
            },
            'value' => $dataProvider->pagination->pageSize
        ]
    )->label('<br/>Количество обращений на странице:'); ?>

<?php ActiveForm::end(); ?>