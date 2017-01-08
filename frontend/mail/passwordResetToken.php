<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $token string */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/sign-in/reset-password', 'token' => $token]);
?>
<table>
    <tr>
        <td>
            <h3 class="text">Hello <?php echo Html::encode($user->username) ?>,</h3>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="text">Follow the link below to reset your password:</h3>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="text"><?php echo Html::a(Html::encode($resetLink), $resetLink) ?></h3>
        </td>
    </tr>
</table>
