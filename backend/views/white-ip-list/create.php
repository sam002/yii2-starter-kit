<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WhiteIpList */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'White Ip List',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'White Ip Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="white-ip-list-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
