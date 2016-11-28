<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        // Pages
        ['pattern'=>'page/<slug>', 'route'=>'page/view'],

        // Pages
        ['pattern'=>'author/<username>', 'route'=>'author/show'],

        // Articles
        ['pattern'=>'article/index', 'route'=>'article/index'],
        ['pattern'=>'article/attachment-download', 'route'=>'article/attachment-download'],
        ['pattern'=>'article/<slug>', 'route'=>'article/view'],

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']],

        //Sitemap
        ['pattern' => 'sitemap', 'route' => 'sitemap/default/sitemap-index', 'suffix' => '.xml'],
        [
            'pattern' => 'sitemap_<name:.+?><delimetr:_+><page:(\d+)>',
            'route' => 'sitemap/default/sitemap',
            'defaults' => [
                'delimetr' => null,
                'page' => null
            ],
            'suffix' => '.xml',
        ]
    ]
];
