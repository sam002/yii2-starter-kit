<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lav45\translate\models\Lang */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Lang',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="lang-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
