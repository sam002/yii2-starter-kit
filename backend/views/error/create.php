<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ErrorCounter */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Error Counter',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Error Counters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="error-counter-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
