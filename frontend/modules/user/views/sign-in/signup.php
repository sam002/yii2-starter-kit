<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('frontend', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?php echo $form->field($model, 'username') ?>
            <?php echo $form->field($model, 'email') ?>
            <?php echo $form->field($model, 'password')->widget(PasswordInput::classname(), [
                'pluginOptions' => [
                    'showMeter' => false,
                    'toggleMask' => false
                ],
                'pluginEvents' => [
                    "keyup" => "function() {
                            styles = [
                                '',
                                'form-group-danger', 
                                'form-group-warning', 
                                'form-group-material-orange', 
                                'form-group-material-lime', 
                                'form-group-success'
                                ];
                                $(this).parents('.form-group').removeClass('has-error has-success');
                                $(this).parent().attr('class', styles[$(this).strength('verdict')]);
                         }",
                ]
            ]); ?>
            <?php echo \kartik\helpers\Html::button('Generate password', [
                'class' => 'btn btn-primary',
                'onclick' => 'fillPassword()'
            ]) ?>

            <script>
                function fillPassword() {
                    var genPassword = generatePassword();
                    $("#signupform-password").val(genPassword);
                }
            </script>
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <h2><?php echo Yii::t('frontend', 'Or signup with') ?>:</h2>
            <?php echo $this->render('_oauth') ?>
        </div>
    </div>
