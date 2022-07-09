<?

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;
use yii\widgets\MaskedInput;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">Благодарим Вас за обращение к нам. Мы ответим вам как можно скорее.</div>

    <?php elseif(Yii::$app->session->hasFlash('contactFormNotSubmitted')): ?>
        
        <div class="alert alert-danger">Произошла ошибка при отправке данных.</div>

    <?php else: ?>
        <div class="feedback-default-index">
            <?php $form = ActiveForm::begin(['id' => 'appeal-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($model, 'surname')->textInput(['autofocus' => true, 'value' => 'Иванов']) ?>

                <?= $form->field($model, 'name')->textInput(['value' => 'Иван']) ?>

                <?= $form->field($model, 'patronymic')->textInput(['value' => 'Иванович']) ?>

                <?= $form->field($model, 'phoneNumber')->widget(MaskedInput::className(), [
                    'mask' => '+7 (999) 999-99-99',
                    'clientOptions' => [                   
                        'greedy' => false,
                        'clearIncomplete' => false
                    ]
                    
                ])->input(['value' => '79853698425']); ?>

                <?= $form->field($model, 'email')->input('email', ['value' => 'abc@mail.ru']); ?>

                <?= $form->field($model, 'text')->textArea(['rows' => 6, 'value' => 'Текст обращения']) ?>

                <?= $form->field($model, 'file')->fileInput() ?>
            
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction' => '/feedback/appeals/captcha',
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>        
        </div>
    <?php endif; ?>
</div>