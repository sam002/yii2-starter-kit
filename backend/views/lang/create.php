<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lav45\translate\models\Lang */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Lang',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Langs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
