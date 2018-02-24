<?php
use common\models\ErrorCounter;
use katech91\sitemap\behaviors\SitemapBehavior;

$config = [
    'on beforeRequest' => function($event) {
        $ip = Yii::$app->request->getUserIP();
        if (!\common\models\WhiteIpList::findOne($ip)) {
            /** @var ErrorCounter $bucket */
            $bucket = ErrorCounter::findOne($ip);
            if (!empty($bucket) && !$bucket->allow()) {
                $totalTime = Yii::$app->keyStorage->get('common.blocking-timeout') ? : ErrorCounter::DEFAULT_TIME_STEP;
                /** @var int $timeToUnblock */
                $timeToUnblock = $totalTime - time() + $bucket->lastErrorTime;
                throw new \yii\web\ForbiddenHttpException(
                    'Limit of errors exceeded. You should waiting for ' .
                    (int)$timeToUnblock . ' seconds'
                );
            }
        }
    },
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => frontend\modules\user\Module::class,
            'shouldBeActivated' => false,
            'enableLoginByPass' => false,
        ],
        'api' => [
            'class' => frontend\modules\api\Module::class,
            'modules' => [
                'v1' => frontend\modules\api\v1\Module::class
            ]
        ],
        'sitemap' => [
            'class' => 'katech91\sitemap\Sitemap',
            'models' => [
                'article' =>  'common\models\Article',
                'page' => 'common\models\Page',
            ],
            'urls' => [
                // your additional urls
                [
                    'loc' => '/article/index',
                    'changefreq' => \katech91\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.8,
                ],
            ],
            'enableGzip' => true, // default is false
            'cacheExpire' => 1, // 1 second. Default is 24 hours
        ],
    ],
    'components' => [
        'authClientCollection' => [
            'class' => yii\authclient\Collection::class,
            'clients' => [
                'vkontakte' => [
                    'class' => yii\authclient\clients\VKontakte::class,
                    'clientId' => env('VK_CLIENT_ID'),
                    'clientSecret' => env('VK_CLIENT_SECRET'),
                ],
                'google' => [
                    'class' => yii\authclient\clients\Google::class,
                    'clientId' => env('GOOGLE_CLIENT_ID'),
                    'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
                ],
                'github' => [
                    'class' => yii\authclient\clients\GitHub::class,
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class' => yii\authclient\clients\Facebook::class,
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class'=>yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl'=>['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],
        'reCaptcha' => [
            'name' => 'verifyCode',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => env('RECAPTCHA_SITE_KEY'),
            'secret' => env('RECAPTCHA_SECRET_KEY'),
        ],
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'=>yii\gii\Module::class,
        'generators'=>[
            'crud'=>[
                'class'=>yii\gii\generators\crud\Generator::class,
                'messageCategory'=>'frontend'
            ]
        ]
    ];
    $config['components']['reCaptcha']['siteKey' ] = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';
    $config['components']['reCaptcha']['secret'] = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
}

return $config;
