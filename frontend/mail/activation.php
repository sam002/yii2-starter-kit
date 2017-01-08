<?php
/**
 * @var $this \yii\web\View
 * @var $url \common\models\User
 */
?>
<h3 class="text">
    <?php echo Yii::t('frontend', 'Your activation link: {url}', ['url' => Yii::$app->formatter->asUrl($url)]) ?>
</h3>