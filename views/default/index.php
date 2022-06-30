<?
use app\modules\models\AppealForm;
/*
use yii\widgets\ActiveForm;
use yii\helpers\Html;
*/
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$model = new AppealForm;
$this->title = 'Feedback';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-contact">
    <h1>Appeal</h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>
        <div class="feedback-default-index">
            <?php $form = ActiveForm::begin(['id' => 'appeal-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <?= $form->field($model, 'surname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'patronymic')->textInput() ?>

                <?= $form->field($model, 'phoneNumber')->textInput() ?>

                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'text')->textArea(['текст', 'rows' => 6]) ?>

                <?= $form->field($model, 'file')->fileInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>        
        </div>
    <?php endif; ?>
</div>