<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Error Counters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="error-counter-index">


    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Error Counter',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ip',
            'allowance',
            'lastErrorTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
