<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MailAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@frontendUrl';

    public $css = [
        'css/html.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
