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
                'onclick' => 'generatePassword()'
            ]) ?>

            <script>
                function generatePassword() {
                    if (window.crypto.getRandomValues === 'undefined') {
                        alert("Your browser doesn't defend a generator of cryptographically secure random numbers.We " +
                            "can't generate secure password.");
                    } else {
                        var genPassword = "";

                        //A generator of cryptographically secure random numbers

                        var numPassword = new Uint8Array(10);
                        window.crypto.getRandomValues(numPassword);

                        //Transform random numbers to ascii symbols from #33 to #126

                        var interval = 256 / 94;
                        var asciiNumber = 0;

                        for (var i = 0; i < numPassword.length; i++) {
                            asciiNumber = Math.floor((numPassword[i]) / interval) + 33;
                            genPassword += String.fromCharCode(asciiNumber);
                        }
                        $("#signupform-password").val(genPassword);

                        return genPassword;
                    }
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
