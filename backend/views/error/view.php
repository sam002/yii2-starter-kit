<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ErrorCounter */

$this->title = $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Error Counters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="error-counter-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->ip], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->ip], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ip',
            'allowance',
            'lastErrorTime',
        ],
    ]) ?>

</div>
