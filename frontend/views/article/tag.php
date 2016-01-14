<?php
/**
 * Author: Semen Dubina
 * Date: 13.01.16
 * Time: 15:38
 */
$max = \common\models\Tag::find()->max('frequency');
$average = \common\models\Tag::find()->average('frequency');
if (!isset($model->frequency) || !is_numeric($model->frequency) || $model->frequency < $average/2) {
    $level = 'defult';
} elseif($model->frequency >= $average/2) {
    $level = 'info';
} elseif ($model->frequency > $average) {
    $level = 'warning';
} elseif ($model->frequency > ($average + $max)/2) {
    $level = 'danger';
};
?>


<span class="label label-<?php echo $level ?>"><?php echo $model->name ?></span>