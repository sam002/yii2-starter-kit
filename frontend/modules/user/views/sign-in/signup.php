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
                                            'linear-gradient(#D2D2D2, #D2D2D2)',
                                            'linear-gradient(#F44336, #F44336), linear-gradient(#D2D2D2, #D2D2D2)', 
                                            'linear-gradient(#FF5722, #FF5722), linear-gradient(#D2D2D2, #D2D2D2)', 
                                            'linear-gradient(#ff9800, #ff9800), linear-gradient(#D2D2D2, #D2D2D2)', 
                                            'linear-gradient(#cddc39, #cddc39), linear-gradient(#D2D2D2, #D2D2D2)', 
                                            'linear-gradient(#4caf50, #4caf50), linear-gradient(#D2D2D2, #D2D2D2)'
                                        ];
                                        $(this).parents('.form-group').removeClass('has-error has-success');
                                        $(this).css('background-image', styles[$(this).strength('verdict')]);
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
