<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'body')->widget(
        CKEditor::className(),
        [
            'preset'=> "full",
            'clientOptions' => ElFinder::ckeditorOptions('file-manager-elfinder',[
                'height' => '500px',
                'skin' => 'moono-lisa'
            ]),
        ]
    ) ?>

    <?php echo $form->field($model, 'view')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
