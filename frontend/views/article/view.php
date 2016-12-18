<?php
/* @var $this yii\web\View */
use yii\bootstrap\Html;

/* @var $model common\models\Article */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$bundle = \frontend\assets\FrontendAsset::register($this);
?>
<div class="content">
    <article class="article-item">
        <h1><?php echo $model->title ?></h1>

        <div class="small">
            <?php echo $this->render('/tag/article_tag', [
                    'models' => $model->tags
            ]); ?>
        </div>
        <hr>
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
            <?php endif;
            ?>
        </div>
        <footer>
            <div class="entry-author">
                <?php
                /** @var \common\models\UserProfile $profile */
                $profile = $model->getAuthor()->one()->getUserProfile()->one();
                ?>

                <img src="<?php echo $profile->getAvatar() ?>" class="img-circle avatar pull-left" width="96px" />
                <h3 class="author vcard">
                    <span class="fn">
                        <?php echo Html::a($profile->getFullName(), ['author/show', 'username'=>$profile->user->username]) ?>

                    </span>
                </h3>
                <p class="author-bio"></p>
            </div>
            <div class="clear"></div>
        </footer>
    </article>
</div>
