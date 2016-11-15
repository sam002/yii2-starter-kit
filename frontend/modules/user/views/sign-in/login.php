<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h1><?php echo Html::encode($this->title) ?></h1>
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="col-sm-6">
            <?php echo $form->field($model, 'identity') ?>
            <?php echo $form->field($model, 'password')->passwordInput() ?>
            <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                    'link' => yii\helpers\Url::to(['sign-in/request-password-reset'])
                ]) ?>
            </div>
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <div class="form-group">
                <?php echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="col-sm-6">
            <h2><?php echo Yii::t('frontend', 'Or login with') ?>:</h2>
            <div class="form-group">
                <?php echo $this->render('_oauth') ?>
            </div>
        </div>

    </div>

</div>
