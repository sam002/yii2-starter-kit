<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 03.11.16
 * Time: 19:31
 */
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;

/* @var $model common\base\MultiModel */
?>
<?php $authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['/user/sign-in/oauth']
]); ?>

<div class="list-group">
    <?php
    /** @var \yii\authclient\ClientInterface $client */
    foreach ($authAuthChoice->getClients() as $client) { ?>
        <div class="list-group-item">
            <div class="row-action-primary link">
                <?php $mapIcons = ['vkontakte' => 'fa-vk'];
                $socIcon = isset($mapIcons[$client->getName()]) ? $mapIcons[$client->getName()] : 'fa-' . $client->getName() ?>

                <a id="<?php echo ucfirst($client->getName()); ?>_login"
                   href="<?php echo $authAuthChoice->createClientUrl($client) ?>">
                    <?php echo Html::tag('i', '', ['class' => 'fa ' . $socIcon . " fa-2x"]); ?>
                </a>
            </div>
            <div class="row-content">
                <h4 class="list-group-item-heading">
                    <a href="<?php echo $authAuthChoice->createClientUrl($client) ?>">
                        <?php echo ucfirst($client->getName()); ?>
                    </a>
                </h4>
            </div>
        </div>
    <?php } ?>

</div>
<?php AuthChoice::end(); ?>
