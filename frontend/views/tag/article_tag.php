<?php
/**
 * Author: Semen Dubina
 * Date: 13.01.16
 * Time: 15:38
 */

use kartik\helpers\Html;

foreach ($models as $tag) {
    echo Html::a($this->render('_item', ['model' => $tag]), \yii\helpers\Url::to(['index', 'ArticleSearch[tagValues]' => $tag->name])) . " ";
}
