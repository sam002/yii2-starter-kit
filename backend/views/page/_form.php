<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 2048]) ?>

    <?= $form->field($model, 'body')->widget(
        dosamigos\ckeditor\CKEditor::className(),
        [
<<<<<<< HEAD
            'clientOptions' => ElFinder::ckeditorOptions('file-manager-elfinder',[
                'height' => '500px',
            ]),
=======
            'preset'=> "full",
            'options'=>[
                'filebrowserBrowseUrl'=>Yii::$app->urlManager->createUrl(['/file-storage/upload']),
                'filebrowserUploadUrl'=>Yii::$app->urlManager->createUrl(['/file-storage/upload']),
                '_minHeight'=>200,
                '_maxHeight'=>200
            ]
>>>>>>> develop
        ]
    ) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
