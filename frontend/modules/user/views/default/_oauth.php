<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 25.10.16
 * Time: 12:21
 */
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;

/** @var \common\models\Oauth[] $providers */
/* @var $model common\base\MultiModel */
?>
<?php $authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['/user/sign-in/oauth']
]); ?>
<?php $oauth = [];
foreach ($providers as $provider) {
    $oauth[$provider->provider] = $provider;
}
?>
<div class="list-group">
    <?php
    /** @var \yii\authclient\ClientInterface $client */
    foreach ($authAuthChoice->getClients() as $client) { ?>
        <div class="list-group-item">
            <?php
            if (isset($oauth[$client->getName()])) {

                $params = json_decode($oauth[$client->getName()]->properties, true);
                ?>
                <div class="row-picture">
                    <img class="circle" src="<?php echo $params['avatar_url'] ?>" alt="icon">
                </div>
                <div class="row-content">
                    <h4 class="list-group-item-heading"><?php echo ucfirst($client->getName()); ?></h4>
                    <p class="list-group-item-text"> <?php echo $params['login'] ?> </p>
                </div>
            <?php } else { ?>
                <div class="row-action-primary">
                    <?php $mapIcons = ['vkontakte' => 'fa-vk'];
                    $socIcon = isset($mapIcons[$client->getName()]) ? $mapIcons[$client->getName()] : 'fa-' . $client->getName() ?>
                    <?php echo Html::tag('i', '', ['class' => 'fa fa-2x ' . $socIcon]); ?>
                </div>
                <div class="row-content">
                    <h4 class="list-group-item-heading"><?php echo ucfirst($client->getName()); ?></h4>
                    <p class="list-group-item-text"><a href="<?php echo $authAuthChoice->createClientUrl($client) ?>">Link
                            Account</a></p>
                </div>
            <?php } ?>

        </div>
    <?php } ?>
</div>

<?php AuthChoice::end(); ?>
