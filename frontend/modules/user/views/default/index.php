<?php

use trntv\filekit\widget\Upload,
    yii\helpers\Html,
    yii\widgets\ActiveForm,
    kartik\password\PasswordInput,
    yii\bootstrap\Modal;

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

    <?php echo $form->field($model->getModel('profile'), 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

    <?php echo $form->field($model->getModel('profile'), 'gender')->dropDownlist([
        \common\models\UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Female'),
        \common\models\UserProfile::GENDER_MALE => Yii::t('frontend', 'Male')
    ], ['prompt' => '']) ?>

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
                ]);
            
                echo $form->field($model->getModel('account'), 'password_confirm')->passwordInput();
            ?>
            </div>
        <div class="col-sm-6">
            <?php echo $this->render('_oauth', ['providers' => $model->getModel('oauth')]) ?>
        </div>
    </div>
    <div class="row">
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
        echo $form->field($model->getModel('account'), 'password_current')->passwordInput();
    
    
        echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary']);
        Modal::end();
    
        ActiveForm::end(); ?>
    </div>


</div>
