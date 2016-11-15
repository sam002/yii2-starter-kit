<?php

/* @var $this yii\web\View */
/* @var $model common\models\ErrorCounter */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Error Counter',
]) . ' ' . $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Error Counters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->ip]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="error-counter-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
