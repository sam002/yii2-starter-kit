<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarouselItem */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="widget-carousel-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model) ?>

    <?= $form->field($model, 'image')->widget(
        \trntv\filekit\widget\Upload::className(),
        [
            'url'=>['/file-storage/upload'],
        ]
    ) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 1024]) ?>

    <?= $form->field($model, 'caption')->widget(
        dosamigos\ckeditor\CKEditor::className(),
        [
            'preset'=> "full",
            'options'=>[
                'filebrowserBrowseUrl'=>Yii::$app->urlManager->createUrl(['/file-storage/upload']),
                'filebrowserUploadUrl'=>Yii::$app->urlManager->createUrl(['/file-storage/upload']),
                '_minHeight'=>200,
                '_maxHeight'=>200
            ]
        ]
    ) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
