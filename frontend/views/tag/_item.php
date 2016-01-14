<?php
/**
 * Author: Semen Dubina
 * Date: 13.01.16
 * Time: 15:38
 */

use kartik\helpers\Html;

$max = \common\models\Tag::find()->max('frequency');
$average = \common\models\Tag::find()->average('frequency');
$level = Html::TYPE_DEFAULT;
if($model->frequency >= $average/2) {
    $level = Html::TYPE_INFO;
} elseif ($model->frequency > $average) {
    $level = Html::TYPE_WARNING;
} elseif ($model->frequency > ($average + $max)/2) {
    $level = Html::TYPE_DANGER;
};

echo Html::bsLabel($model->name, $level);
