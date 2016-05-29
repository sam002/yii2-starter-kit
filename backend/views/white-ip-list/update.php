<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WhiteIpList */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'White Ip List',
]) . ' ' . $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'White Ip Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->ip]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="white-ip-list-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
