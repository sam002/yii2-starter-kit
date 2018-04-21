<?php

use lav45\translate\models\Lang,
    trntv\filekit\widget\Upload,
    yii\helpers\Html,
    yii\widgets\ActiveForm,
    kartik\password\PasswordInput,
    yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\base\MultiModel */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'User Settings')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(['action' => 'profile']); ?>

    <h2><?php echo Yii::t('frontend', 'Profile settings') ?></h2>

    <?php echo $form->field($model->getModel('profile'), 'picture')->widget(
        Upload::classname(),
        [
            'url' => ['avatar-upload']
        ]
    )?>

    <?php echo $form->field($model->getModel('profile'), 'firstname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model->getModel('profile'), 'middlename')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model->getModel('profile'), 'lastname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field(
            $model->getModel('profile'), 'locale')
        ->dropDownlist(ArrayHelper::map(Lang::find()->active()->all(), 'locale', 'name')
    ) ?>

    <?php echo $form->field($model->getModel('profile'), 'gender')->dropDownlist([
        \common\models\UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Female'),
        \common\models\UserProfile::GENDER_MALE => Yii::t('frontend', 'Male')
    ], ['prompt' => '']) ?>
    
    <?php echo $form->field($model->getModel('profile'),'about')->textarea(['rows'=>5,'cols'=>10,'maxlength'=>1024])
        ->hint("Please, write down an information about yourself. This information will be avaliable for site's 
        visitors if you publish an article.") ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('frontend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
<div class="user-account_form">
    <h2><?php echo Yii::t('frontend', 'Account Settings') ?></h2>

    <div class="row">
        <div class="col-sm-6">
            <?php
            $form = ActiveForm::begin([
               'id' => 'accountForm'
            ]);
                echo $form->field($model->getModel('account'), 'username');

                echo $form->field($model->getModel('account'), 'email');

                echo $form->field($model->getModel('account'), 'password')->widget(PasswordInput::classname(), [
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
                ]);

                echo $form->field($model->getModel('account'), 'password_confirm')->passwordInput();
            ?>
            </div>
        <div class="col-sm-6">
            <?php echo $this->render('_oauth', ['providers' => $model->getModel('oauth')]) ?>
        </div>
    </div>
    <div class="row">
        <?php echo \kartik\helpers\Html::button('Generate password', [
        'class' => 'btn btn-primary',
        'onclick' => 'fillPassword()'
        ]) ?>

        <script>
            function fillPassword() {
                var genPassword = generatePassword();
                $("#accountform-password").val(genPassword);
                $("#accountform-password_confirm").val(genPassword);
            }
        </script>
        <?php $modal = Modal::begin([
            'header' => '<h2>' . Yii::t('frontend', 'Please, enter your password') . '</h2>',
            'toggleButton' => ['label' => Yii::t('frontend', 'Update'), 'class' => 'btn btn-primary'],
            'clientEvents' => [
                "show.bs.modal" => "function() {
                        if($('#accountForm').data('yiiActiveForm').validated) {
                            $('#accountform-password_current').val('');
                            $('#accountForm').data('yiiActiveForm').submitting = false;
                            return true;
                        }
                        var modal = $(this);
                        
                        $('#accountform-password_current').val('_' + Math.random());
                        
                        var triggerFormCheck = function(e) {
                            modal.modal('show');
                            return false;
                        };
                        
                        $('#accountForm').on('beforeSubmit', triggerFormCheck);
                        setTimeout(function () {
                            $('#accountForm').off('beforeSubmit', triggerFormCheck);
                        }, 300);
                        $('#accountForm').data('yiiActiveForm').submitting = true;
                        $('#accountForm').yiiActiveForm('validate');
                        return false;
                    }"
                ]
            ]);
        echo $form->field($model->getModel('account'), 'password_current')->passwordInput(); ?>

        <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary']);
        Modal::end();

        ActiveForm::end(); ?>
    </div>


</div>
