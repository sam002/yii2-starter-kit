<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories common\models\ArticleCategory[] */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories,
            'id',
            'title'
        ), ['prompt'=>'']) ?>

    <?php echo $form->field($model, 'body')->widget(
        CKEditor::className(),
        [
            'preset'=> "full", //basic, full, standart
            'clientOptions' => ElFinder::ckeditorOptions('image-manager-elfinder',[
                'height' => '500px',
                'skin' => 'moono-lisa'
            ]),
        ]
    ) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);
    ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]);
    ?>
    <?php echo $form->field($model, 'tagValues')->widget(
        Select2::className(),
        [
            'language' => Yii::$app->keyStorage->get('common.publication-lang'),
            'theme' => Select2::THEME_BOOTSTRAP,
            'showToggleAll'=> false,
            'options' => [
                'placeholder' => Yii::t('backend','Add tags'),
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'tags' => true,
                'tokenSeparators' => [',', '\n'],
                'minimumInputLength' => 1,
                'ajax' => [
                    'url' => Url::to(['/article-tag/list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {query:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(tag) { return tag.text; }'),
                'templateSelection' => new JsExpression('function (tag) { return tag.text; }'),
            ],
        ]
    );
    ?>

    <?php echo $form->field($model, 'view')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>
    <?php echo $form->field($model, 'private')->checkbox() ?>

    <?php echo $form->field($model, 'published_at')->widget(
        DateTimeWidget::className(),
        [
            'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
        ]
    ) ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
