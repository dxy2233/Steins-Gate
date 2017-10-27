<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        // Session存储机制
        'session' => [
            'name' => 'frontendSID',
            'cookieParams' => [
//                'domain' => '.' . DOMAIN,
                'lifetime' => 0
            ],
            'timeout' => 3600
        ],
        'urlManager' => [
            'class'=>yii\web\UrlManager::className(),
            'enablePrettyUrl' => true,
            'showScriptName' => true,
//            'suffix' => '.html',
            'rules' => [
                'index' => 'index/index/index',
                'login' => 'site/login',
                'user' => 'user/center/index',
                'user_info'=>'user/center/info',
                'goods-<shop_id:\d+>-<id:\d+>' => 'goods/goods/info',
                'goods_list-<cat_id:\d+>' => 'goods/list/index'   //分类列表
            ],
        ],

    ],
    'params' => $params,
    'defaultRoute'=>'index/index',
];
