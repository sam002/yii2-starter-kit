<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use sam002\otp\widgets\OtpInit;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = Yii::t('backend', 'Edit account')
?>

<div class="user-profile-form">


    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-7">

                <?php echo $form->field($model, 'username') ?>

                <?php echo $form->field($model, 'email') ?>

                <?php echo $form->field($model, 'password')->passwordInput() ?>

                <?php echo $form->field($model, 'password_confirm')->passwordInput() ?>

            </div>

            <div class="col-lg-5">
                <?php echo $form->field($model, 'secret')->widget(
                    OtpInit::className() ,[
                        'component'=>'otp',
                        'link' => 'ADD OTP BY LINK',
                        'QrParams' => [
                            'size' => 3
                        ]
                ]); ?>

                <?php echo $form->field($model, 'otpCode')->passwordInput() ?>

            </div>
        </div>

    <div class="form-group pull-right">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
