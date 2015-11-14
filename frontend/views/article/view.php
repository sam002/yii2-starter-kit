<?php
/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$bundle = \frontend\assets\FrontendAsset::register($this);
?>
<div class="content">
    <article class="article-item">
        <h1><?php echo $model->title ?></h1>
        <div class="entry-content">
            <?php if ($model->thumbnail_path): ?>
                <?php echo \yii\helpers\Html::img(
                    Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $model->thumbnail_path,
                        'w' => 200
                    ], true),
                    ['class' => 'article-thumb img-rounded pull-left']
                ) ?>
            <?php endif; ?>

            <?php echo $model->body ?>

            <?php if (!empty($model->articleAttachments)): ?>
                <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
                <ul id="article-attachments">
                    <?php foreach ($model->articleAttachments as $attachment): ?>
                        <li>
                            <?php echo \yii\helpers\Html::a(
                                $attachment->name,
                                ['attachment-download', 'id' => $attachment->id])
                            ?>
                            (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <footer>
            <div class="entry-author">
                <?php $profile = $model->getAuthor()->one()->getUserProfile()->one();
                ?>

                <img src="<?php echo $profile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle avatar pull-left" width="96px" />
                <h3 class="author vcard">
                    <span class="fn">
                        <a href="/" title="<?php echo $profile->getFullName() ?>" rel="author"><?php echo $profile->getFullName() ?></a>
                    </span>
                </h3>
                <p class="author-bio"></p>
            </div>
            <div class="clear"></div>
        </footer>
    </article>
</div>