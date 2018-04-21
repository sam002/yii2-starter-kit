<?php

use lav45\translate\models\Lang;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Langs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Lang',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'locale',
            'name',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Lang::getStatusList()[$model->status];
                },
                'filter' => Lang::getStatusList()
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
