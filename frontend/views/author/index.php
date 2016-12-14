<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 19.11.16
 * Time: 10:11
 */

/* @var $this yii\web\View */
/* @var $author common\models\User */
/* @var $articles common\models\Article */
/* @var $model common\base\MultiModel */


?>

<div class="content">
    <div class="panel">
        <div class="panel-heading">
            <h1><?php echo Yii::t('frontend', 'Author') ?></h1>
        </div>
        <div class="panel-body">
            <div class="row">
                
                <div class="col-sm-3">
                    <?php if ($author['avatar_url']) { ?>
                        <img src="<?php echo($author['avatar_url']); ?>">
                    <?php } ?>
                </div>
                
                <div class="col-sm-6">
                    <h2><?php echo $author['username'] ?></h2>
                    
                    <h3><?php echo $author['full_name'] ?></h3>
                    
                    <?php if($author['about']){ ?>
                        <h3>About</h3>
                        <p><?php echo $author['about']; ?></p>
                    <?php }?>
                    
                    <?php if($author['oauth']){ ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <h4>Social links</h4>
                        </div>
                        <div class="col-sm-2">
                            <a href="<?php echo($author['oauth']['url']) ?>">
                                <i class="<?php echo common\assets\oauthHelper::socialIcon($author['oauth']['provider']) ?>"
                                   aria-hidden="true"></i> </a>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <?php echo \yii\widgets\ListView::widget([
        'dataProvider' => $articles,
        'pager' => [
            'hideOnSinglePage' => true,
        ],
        'itemView' => '/article/_item'
    ]) ?>


</div>