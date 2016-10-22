<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:40 AM
 */

namespace common\assets;

use yii\web\AssetBundle;

class MaterialDesign extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-material-design/dist';
    public $js = [
        'js/material.min.js',
        'js/ripples.min.js'
    ];
    public $css = [
        'css/ripples.min.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesome',
        'common\assets\JquerySlimScroll'
    ];
}
